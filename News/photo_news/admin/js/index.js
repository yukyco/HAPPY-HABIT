if (!window.requestAnimationFrame) {
	window.requestAnimationFrame = (function () {
		return window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function (callback, element) {
			window.setTimeout(callback, 1000 / 60);
		};
	})();
}

(function () {
	var canvas = document.getElementById('canvas');
	if (!canvas || !canvas.getContext) return false;
	var ctx = canvas.getContext('2d');

	var width = canvas.width;
	var height = canvas.height;

	var heart_points = [
		[251,343],[236,358],[266,329],[220,377],[220,377],[326,266],[296,296],[280,313],[326,266],[311,282],[343,250],[343,250],[373,219],[358,233],[388,205],[401,187],[409,170],[401,187],[409,170],[414,152],[414,134],[411,115],[405,100],[396,85],[384,73],[370,61],[354,51],[338,47],[321,45],[304,46],[289,50],[275,57],[262,64],[249,74],[238,85],[227,93],[181,343],[196,358],[166,329],[212,377],[106,266],[136,296],[152,313],[106,266],[121,282],[89,250],[89,250],[59,219],[74,233],[44,205],[31,187],[23,170],[31,187],[23,170],[18,152],[18,134],[21,115],[27,100],[46,72],[36,85],[62,61],[78,51],[94,47],[111,45],[128,46],[143,50],[157,57],[170,64],[183,74],[194,85],[205,93],[216,104] ];
	var num_heart_points = heart_points.length;

	var imageSrcs = [
		'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABHNCSVQFBQUFTaUt9gAAAexJREFUaIHtmaGSgzAQhisrkbxCJfJsZWVlLRIZia08icRWIivPIiuR9yp72ZlwE7gkTcIu5DoVn2lndv8PQkLCDgB2r8DmAd4ibxGAQnKUXBQn9RtVmIOqibVLyVnyIckpRLCIkHxJvi3gf5UkixTAwDdH/YekUVJRIpWjuIlBXcmQO3wP7IFC+xAR1xV6RmtrtuAi6fRgGG6mJu2CJvpws8nUBPUf8/rzJiVBE11mXl8Q1m9tInvCJvqYHusfGer/zppU49an2cBQ+2YS6ZlEOsknU20k00UOjI24uegiVQKBYql1kWsCgWJpdBGKtWMr2pcU4ZxVuJkMrTqBQLHUusglgUCxlLpInkCgWAqYreyuzVOq9LDiuxYnwiSSJRAslMwkgjQJhPNF3yL8EflPD/1ku8u1FeVGzHPbDgceCYS1YdpCW0WKBALbOISIUB8UUFHZ8rpEUnsrnsxSoSKprPj3Zzl9RHDR6TeUcB32BYlsKeMlESKyhYy3RKjIKNOtINFB4GeKUJGRhlHCOTtRiyCCQULE5lkigpyA5kx3ULWisywVQXJY9tx04PmdkFtkpIqQqKn6U4oghefdwan1SNmbWmSkBPuzIzh6cokgOUynabxTxlfw1EVGzqC+YXCyhsgqbB7gLfKqIj+GyN0YAxfsSAAAAABJRU5ErkJggg==',
		'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABHNCSVQFBQUFTaUt9gAAAdhJREFUaIHtmSuPhDAQgFcikVgkEolFIpHYlUgk9v53r5MrucL2NWWGFrLiyyWXpTMffdHpSwjxegLJE/iKPFtknkOoJI2kVTTqf6HPY9rv1N9aUnifDRApJb1klvxYmNVv/AHNQMJvR/urZFRSUSKdo3FbwA7ZA64XZGIyvjCHyIQMcAzmk+hPtL+Iv5HiFTkjoQ8321AbCNpfd+0bRLDDySdD2RP2njeIUAUxDbOaof3KJELZGzrbarOyvaiDyMIkAkvryNQ2UOgiFWMgblpdhGtYXcGgi1AsiakYdRGKvSMV0yNFOFeVS0XuPEd2k73NIKFYOl2kzCChWKrjzo49G+TAIi781uKkN4kUGSSGpTCJ3G0/GYXjPHKnSf9/3LUcde+wp/S7nB3FB45DEBXLR74OEY5jKRUVRoS6UECFuW4WUGnMaRWz18sCa7857Pim0hJaBDYdrsLEeQmESEoZvwRSJIXM5zJLJLLJuK4AqHgLzDVFhMgVq9kYEJ9MBODYZ3pEfDIRAK7KKD5nVtVWXB4EIhTzBp4tT+VAJHJmqA0ksYlFgDqwd2B/iB9KF4hswMedbe7ETehEIkAh9hVM6KmKJRazyEYjcNfWJ0QeQPIEviJPFfkF+iPbLZHmzRwAAAAASUVORK5CYII=',
		'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABHNCSVQFBQUFTaUt9gAAAjxJREFUaIHtmSmbgzAQhiuRSCwSicQikUhsZWRlbf/3bKZMFggTzpz7rPie0oNmXubK8QAhHkkL4KvwhgiRSeVShVQlVdL7LBUQNLyR6qWeUh+pt5SgV/y82wUKDNKQ8W8CMEl9XxuBAoFgyAw7xpvEeycASEYQe17Y8s6wggkA0l8E0GHaBYxnkOaGJ3S9YMwZ7yA5DW4DQmkKsQsgmeF6T61liKVXDoKgwQXd1NKTwLLZ0zWGTLlzv3AAovrMIZCcjNfrPXc90G8L7T9KBxBK4jveDkh14Um+yeUNuA2reXhVWyA13KswqkTeaX5HxxkfGgNSW3xaAuxXK10tB+KiTLrWwIWWjc7rH0TzCHrDVuf1qU4HsZUb/kG00OoiMOqs2KqVYn4gyKKP4DTiyGotNmGFXXV2l43LpUdWc60Uc+S3Ys1BWkgrtNBWdhp/d37lW5gfOQdSQFrTkwE2lrp9Il5BG6fFHANyZQ0SKqwmuxkQ7CddAl6ZL9yMS908cq+84MQGXQVxJr5aeS7t3Vmzx1iO1944uIsSW74sc+MESEaeiSHMnkY7T+w0IkzIAjBO1y2AqI22UA2z37Tt4t5v49k7fILfBJl7x+UO4jykamZ8ayDKO2on0VW4bYeUJZC5MBGxVNsMOQGBjqczmHIIS+Wdkj2uxY+O7fDESp2pqCOJs1B84wsAMldOQuM6glJgXG4dy4sAILqn8LUi9SQF94RzR3rBQEzCMCzhTF6wIHSRuoIb8A/yV0F+APcV9dgRMgwBAAAAAElFTkSuQmCC',
		'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABHNCSVQFBQUFTaUt9gAAA6FJREFUaIHVWbtywkAM1LjCnenskm9LPiv/lhI66JyOFFhmb726M8YxRDMae+C80kp7D0x1/fiwjO/Am8BxTA6rhB/F4DFTnOvVKtO2I2+G654cv0MvmcJXMfg7HePzc0KEwRG0A1D3jsZwwBIBTLwTMRgfcRN8JKIINGbWQpDOzA6D42eteE4lzQS6DD7GaDL4CREMUFNFGFw5B6wLBPYDASYzN8aeMK0SQRpLW30YAkUBWgjkV09yb1MCjxRIxZJkKpuS8ERURUqfdeSo84bwS51gGTN+Qsal5VLY02AVKNLywXSSjFl6vhN4OAYlOZKpLJUTzw01odFb+j5aCNQ41b0W4it8vEfp1igtJtCKhyLHKkWdZKKod7XM8rKOY3klG+cIP4Qdyq1AvJTiQoGTU0mHdR4t2TiGY4z5ckd4ra4zASJCal/gTuEuXsI3GIvP4I5fV0OyqiM1AUXGgXkf4smOxZqL71dURw2+432EB889OzEhPhngzr8EH8lgd8auKCJOZolFu3h0yFxinlsiPSZiNmX/qJXmEcZYgqvu5el3LSuRWdWi3yP/xcYp8N+J9H7DRH42TmQ1q+yWvLvR9Z2IcY6JMxH3forzNtbbTCI48N1M5fhjdpNWT65a+GpTOWHOZ+/IBZxZv4txJ5J8WVpn8AsAvJIQxr9YmqMTGon0dk8eu3K2tKVbG8b2XLAbZxu65HMEv2DGr5YY5sD5ed49SssHX8zsZHdi2KEtCaEqMBfPzT8b54iZ7srR7iSwrVuQUXvbZcgJ1TLueWqyI6EjENqKjMrH88CuJPmwtJAAyssBJhvRBiQw/okITaTlIL1N5cUP/xUZPl1wUVlWyTGqEiAoryMBuczWJsPxXTocO5Q5d6TUWiS21pyJYqoC8go6xlW/RxgQwUKNLiCUK1wuFsa82ddX+AtxDhls86Pd4R1bdZy7j2QmpohwkBKZSLcqIO8LTCAqFJNIuhERyZHhoFHFIkcyUZGQBBcpJQGWe/mgyESV8/tIatwFxMt1GudESKJERJFhQt90VXNHHfSOBQwuSJbEHCIOEB0bTiIRrrAvm6ry3+KzRavhI++1oqWSSbkr3UdjcvNslj36gq604rBk0JUEizv2XxFxMn51HWNlVfKKDHfjqZPC0lemrF8/5Kk5wF46ty067jz77je3rOb8ROOfPnyu8RI7t0+cyNU+Y/YkCbN138ZjUqV95Gkpsa39t0LueKKOKavZLzzPP7SUmZ1jAAAAAElFTkSuQmCC',
		'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAABHNCSVQFBQUFTaUt9gAAA6FJREFUaIHVWbtywkAM1LjCnenskt/K/yW/lRI66JyOFFhmb726M8YxRDMae+C80kp7D0x1/fy0jO/Am8BxTA6rhB/F4DFTnOvVKtO2I2+G654cv0MvmcJXMfg7HePra0KEwRG0A1D3jsZwwBIBTLwTMRgfcRN8JKIINGbWQpDOzA6D42eteE4lzQS6DD7GaDL4CREMUFNFGFw5B6wLBPYDASYzN8aeMK0SQRpLW30YAkUBWgjkV09yb1MCjxRIxZJkKpuS8ERURUqfdeSo84bwS51gGTN+Qsal5VLY02AVKNLywXSSjFl6vhN4OAYlOZKpLJUTzw01odFb+j5aCNQ41b0W4it8vEfp1igtJtCKhyLHKkWdZKKod7XM8rKOY3klG+cIP4Qdyq1AvJTiQoGTU0mHdR4t2TiGY4z5ckd4ra4zASJCal/gTuEuXsI3GIvP4I5fV0OyqiM1AUXGgXkf4smOxZqL71dURw2+432EB889OzEhPhngzr8EH8lgd8auKCJOZolFu3h0yFxinlsiPSZiNmX/qJXmEcZYgqvu5el3LSuRWdWi3yP/xcYp8N+J9H7DRH42TmQ1q+yWvLvR9Z2IcY6JMxH3forzNtbbTCI48N1M5fhjdpNWT65a+GpTOWHOZ+/IBZxZv4txJ5J8WVpn8AsAvJIQxr9YmqMTGon0dk8eu3K2tKVbG8b2XLAbZxu65HMEv2DGr5YY5sD5ed49SssHX8zsZHdi2KEtCaEqMBfPzT8b54iZ7srR7iSwrVuQUXvbZcgJ1TLueWqyI6EjENqKjMrH88CuJPmwtJAAyssBJhvRBiQw/okITaTlIL1N5cUP/xUZPl1wUVlWyTGqEiAoryMBuczWJsPxXTocO5Q5d6TUWiS21pyJYqoC8go6xlW/RxgQwUKNLiCUK1wuFsa82cdH+AtxDhls86Pd4R1bdZy7j2QmpohwkBKZSLcqIO8LTCAqFJNIuhERyZHhoFHFIkcyUZGQBBcpJQGWe/mgyESV8/tIatwFxMt1GudESKJERJFhQt90VXNHHfSOBQwuSJbEHCIOEB0bTiIRrrAvm6ry3+KzRavhI++1oqWSSbkr3UdjcvNslj36gq604rBk0JUEizv2XxFxMn51HWNlVfKKDHfjqZPC0lemrF8/5Kk5wF46ty067jz77je3rOb8ROOfPnyu8RI7t0+cyNU+Y/YkCbN138ZjUqV95Gkpsa39t0LueKKOKavZL4J8WHQ7C4jKAAAAAElFTkSuQmCC'];
	var imageCount = imageSrcs.length;

	var numHearts = 300;
	var hearts = [];

	var images = [];
	loadImages();

	function loadImages() {
		for (var i = 0; i < imageCount; i++) {
			images[i] = new Image();
			images[i].src = imageSrcs[i];
		}
		init();
	}

	function init() {
		for (var i = 0; i < numHearts; i++) {
			hearts[i] = new Heart(ctx);
		}
		draw();
	}

	function draw() {
		ctx.clearRect(0, 0, width, height);
		for (var i in hearts) {
			hearts[i].update();
		}
		requestAnimationFrame(draw);
	}

	function Heart(ctx) {
		this.ctx = ctx;
		this.point = heart_points[getRandom(0, num_heart_points - 1)];

		this.offX = getRandom(-5, 5);
		this.offY = getRandom(-5, 5);

		this.scale = getRandom(10, 50);
		this.alphaAngle = 0;
		this.size = 50;
		this.frame = getRandom(1, 60);
		this.erase = (100 - this.frame) / 2;
		this.zoom = 0;
		this.image = images[(getRandom(1, 100) % imageCount)];

		this.update = function () {
			var sz = ~~ ((this.scale * this.size / 100) * (this.zoom / 50));
			this.ctx.globalAlpha = 100 * Math.sin(this.alphaAngle * Math.PI / 180) / 100;
			this.ctx.drawImage(this.image, this.point[0] + this.offX, this.point[1] + this.offY, sz, sz);
			this.erase--;
			if (this.erase > 0) this.alphaAngle += this.scale / 20;
			else this.alphaAngle -= this.scale / 20;
			if (this.alphaAngle < 0) this.alphaAngle = 0;
			this.zoom++;
			this.frame++;
			if (this.frame >= 100 || this.alphaAngle <= 0) this.restart();
		};

		this.restart = function () {
			this.scale = getRandom(10, 50);
			this.alphaAngle = 0;
			this.size = 50;
			this.frame = getRandom(1, 60);
			this.erase = (100 - this.frame) / 2;
			this.zoom = 0;
			this.point = heart_points[getRandom(0, num_heart_points)];
		};
	}

	function getRandom(x1, x2) {
		if (x1 > 0 && x2 > 0) {
			return Math.floor(x1 + Math.random() * (x2 - 1));
		} else {
			return Math.floor(x1 + Math.random() * (-x1 + x2 - 1));
		}
	}
})();
