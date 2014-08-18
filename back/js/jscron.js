	var jsCron = {
				items:[],
				interval: null,
				parse: function(strUnix) {
						return strUnix.match(/^(\d+|\*) (\d+|\*) (\d+|\*) (\d+|\*) (\d|\*)/);
				},
				check: function() {
						var hoy = new Date();
						var test = [new Date(), hoy.getMinutes(), hoy.getHours(), hoy.getDate(), hoy.getMonth(), hoy.getDay()];

						for (var i in this.items) {
							var exec = 0;
							var t = this.parse(this.items[i][1]);
							for (var x in t)
						    if (t[x] && (t[x] == test[x] || t[x] == "*"))exec++;
							if (exec == 5 && this.items[i][0] == 0) {
									this.items[i][2]();
									if (!this.items[i][3])
                                                                                this.items[i][0] = 1;
							} else if (exec < 5 && this.items[i][0] == 1) {
								this.items[i][0] = 0;
							}
						}
				},
				set: function(strUnix, func, rep) {
					if (!/^(\d+|\*) (\d+|\*) (\d+|\*) (\d+|\*) (\d|\*)/.test(strUnix)) return new Error("Formato invalido");
					this.items.push([0, strUnix, func, (rep || false)]);
				},
				init: function(seg) {
					var seg = seg || 1000;
					this.interval = setInterval("jsCron.check()", seg);
				}
		};

		jsCron.init();

