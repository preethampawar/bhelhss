/* Files Gallery 0.9.8 - https://www.files.gallery/ */
!function (e) {
	const t = (e, t) => _c.config && _c.config[e] ? Object.assign(t || {}, _c.config[e]) : t || {};

	function i(e = _c.current_dir.path, t = _c.current_dir.basename, i) {
		var a = (_c.file_names || []).length;
		document.title = _c.config.title ? _c.config.title(e, t, i, a) : _c.title.replace("%name%", t || "/").replace("%path%", e).replace("%count%", a)
	}

	function a(e) {
		return e ? e.replace(/"/g, "&quot;") : ""
	}

	function n(e) {
		return e ? e.replace(/</g, "&lt;").replace(/>/g, "&gt;") : ""
	}

	function o(e, t) {
		return '<span class="' + t + '">' + e + "</span>"
	}

	function s(e) {
		return _c.allow_download && _c.allow_mass_download && te ? `${_c.script}?action=download_dir_zip&dir=${encodeURIComponent(e.path)}&${e.mtime}` : "#"
	}

	_c.config = Object.assign({
		favicon: "<link rel=\"icon\" href=\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%2337474F' d='M20,18H4V8H20M20,6H12L10,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V8C22,6.89 21.1,6 20,6Z' /%3E%3C/svg%3E\" type=\"image/svg+xml\" />",
		title: ("%name% [%count%]" === _c.title || !_c.title) && ((e, t, i, a) => (t || "/") + (i ? "" : " [" + a + "]")),
		panorama: {
			is_pano: (e, t) => {
				var i = e.dimensions[0], a = e.dimensions[1], n = t.max_texture_size;
				if (!(n < 2048 || i < 2048 || i / a != 2)) {
					if (!e.panorama_resized) return n >= i && r(e);
					var o = [i].concat(e.panorama_resized), s = o.pop(), l = screen.availWidth * t.pixel_ratio * 6;
					if (!(s > n)) {
						var c = o.find((e => n >= e && e < l)) || s;
						return c === i ? r(e) : e.url_path.replace(e.basename, "_files_" + c + "_" + e.basename)
					}
				}
			}
		},
		history_scroll: !0,
		load_svg_max_filesize: 1e5,
		localStorage_cache: !0,
		javascript_cache: !0,
		preview_image_cache: !0
	}, _c.config || {}), "isConnected" in Node.prototype || Object.defineProperty(Node.prototype, "isConnected", {
		get() {
			return this.ownerDocument.contains(this)
		}
	});
	var l = {
		a: function (e, t, i) {
			return e ? i ? `<a class="${t} map-link-text" target="_blank" href="${u(e)}">${U.get_svg_icon("marker") + J.span("google maps")}</a>` : `<a class="${t} map-link map-link-icon" target="_blank" href="${u(e)}" data-lang="google maps" title="${J.get("google maps")}">${U.get_svg_icon("marker")}</a>` : ""
		}, span: function (e, t) {
			return e ? '<span class="' + t + ' map-link-icon" data-href="' + u(e) + '"' + x("google maps") + ">" + U.get_svg_icon("marker") + "</span>" : ""
		}
	};

	function r(e, t) {
		var i = !!e.url_path && encodeURI(e.url_path).replace(/#/g, "%23");
		return e.is_dir ? i || "#" : !i || t && ["php", "htaccess"].includes(e.ext) || _c.load_files_proxy_php ? `${_c.script}?action=${t && _c.allow_download ? "download" : "file"}&file=${encodeURIComponent(e.path)}` : i
	}

	function c(e, t) {
		return e.url ? encodeURI(e.url) : e.is_dir ? p(e.path) : r(e, t)
	}

	function p(e) {
		return location.pathname + (e ? "?" + encodeURIComponent(e).replace(/%2F/g, "/") : "")
	}

	function d(e) {
		for (; e.firstChild;) e.firstChild.remove()
	}

	function m(e, t, i) {
		C(e, (function (e) {
			var i = e.target.dataset.action;
			i && t(i, e)
		}), "click", !1, i)
	}

	function u(e) {
		return Array.isArray(e) ? "https://www.google.com/maps/search/?api=1&query=" + e : "#"
	}

	function h(e, t) {
		return e ? '<span class="' + t + '">' + e[0] + " x " + e[1] + "</span>" : ""
	}

	function f(e, t) {
		return e.is_dir ? e.hasOwnProperty("dirsize") ? '<span class="' + t + '">' + filesize(e.dirsize) + "</span>" : "" : '<span class="' + t + '">' + filesize(e.filesize) + "</span>"
	}

	function _(e, t, i) {
		if (!_c.context_menu || !e) return "";
		let a = i ? "span" : "button";
		return `<${a} class="button-icon context-button${t ? ` ${t}` : ""}" data-action="context">${U.get_svg_icon_multi("dots", "close_thin")}</${a}>`
	}

	function g(e, t, i, a) {
		if (!e || !e.iptc) return "";
		var n = Object.keys(e.iptc);
		if (!n.length) return "";
		var o = "", s = "", l = "";
		return n.forEach((function (i) {
			var a = e.iptc[i];
			if (a) {
				if (["city", "sub-location", "province-state"].includes(i)) return s += '<span class="' + t + "-" + i + '">' + a + "</span>";
				if (["creator", "credit", "copyright"].includes(i)) return l += '<span class="' + t + "-" + i + '">' + a + "</span>";
				if ("keywords" === i && Array.isArray(a)) {
					var n = a.filter((e => e));
					return o += n.length ? '<div class="' + t + "-" + i + '">' + n.join(", ") + "</div>" : ""
				}
				return o += '<div class="' + t + "-" + i + '">' + a + "</div>"
			}
		})), (o += (s ? '<div class="' + t + '-location">' + s + "</div>" : "") + (l ? '<div class="' + t + '-owner">' + l + "</div>" : "")) ? i ? '<div class="' + t + '-iptc">' + o + "</div>" : o : ""
	}

	function v(e, t, i) {
		if (!e || !e.exif) return "";
		var a = V(["Model", "ApertureFNumber", "FocalLength", "ExposureTime", "ISOSpeedRatings", "gps"], (function (t) {
			var a = e.exif[t];
			if (!a) return "";
			if ("Model" === t) a = U.get_svg_icon(a.toLowerCase().indexOf("phone") > -1 ? "cellphone" : "camera") + a; else if ("FocalLength" === t && "string" == typeof a) {
				var n = a.split("/");
				2 === n.length && (a = (n[0] / n[1]).toFixed(1) + "<small>mm</small>")
			} else if ("gps" === t) return l[i || "a"](a, "exif-item exif-gps");
			return '<span class="exif-item exif-' + t + '"' + x(t) + ">" + a + "</span>"
		}));
		return a ? '<div class="' + t + '">' + a + "</div>" : ""
	}

	function x(e, t) {
		return e && Y.is_pointer ? ' data-lang="' + e + '"' + (t ? ' data-tooltip="' : ' title="') + J.get(e, !t) + '"' : ""
	}

	function b(e) {
		if (navigator.clipboard) return navigator.clipboard.writeText(e);
		var t = document.createElement("span");
		t.textContent = e, t.style.whiteSpace = "pre", document.body.appendChild(t);
		var i = window.getSelection(), a = window.document.createRange();
		i.removeAllRanges(), a.selectNode(t), i.addRange(a);
		var n = !1;
		try {
			n = window.document.execCommand("copy")
		} catch (e) {
			console.log("error", e)
		}
		return i.removeAllRanges(), window.document.body.removeChild(t), n ? Promise.resolve() : Promise.reject()
	}

	function y(e, t, i, a) {
		e.classList.add(t), i && (e.disabled = i), q(a || 2e3).then((() => {
			e.classList.remove([t]), i && (e.disabled = !1)
		}))
	}

	function w(e, t, i) {
		if (!i && e.which <= 1 && !["meta", "ctrl", "shift", "alt"].some((t => e[`${t}Key`]))) return e.preventDefault();
		const a = !!t && t.getAttribute("href");
		return a && "#" !== a ? (t.contains(e.target) || t.click(), !0) : void 0
	}

	function C(e, t, i, a, n) {
		e.addEventListener(i || "click", function (e, t) {
			return t ? function (a) {
				i || (e.apply(this, arguments), i = setTimeout((function () {
					i = null
				}), t))
			} : e;
			var i
		}(t, n)), a && t()
	}

	function A(e, t) {
		var i;
		return function (a) {
			i && clearTimeout(i), i = setTimeout(e, t || 1e3, a)
		}
	}

	function L(e, t, i, a) {
		return a && (i = A(i, a)), e.addEventListener(t, i), {
			remove: () => {
				e.removeEventListener(t, i)
			}
		}
	}

	_id = document.getElementById.bind(document), _class = function (e, t) {
		return Array.from((t || document).getElementsByClassName(e))
	}, _tag = function (e, t) {
		return Array.from((t || document).getElementsByTagName(e))
	}, _query = function (e, t) {
		return (t || document).querySelector(e)
	}, _querya = function (e, t) {
		return Array.from((t || document).querySelectorAll(e))
	};
	const H = {};

	function k(e, t, i) {
		H[e] && clearTimeout(H[e]), H[e] = setTimeout(t, i)
	}

	function M(e, t) {
		for (var i = e.length, a = 0; a < i; a++) t(e[a], a)
	}

	function V(e, t) {
		for (var i = "", a = e.length, n = 0; n < a; n++) i += t(e[n], n) || "";
		return i
	}

	function z(e, t, i) {
		var a = new RegExp("[" + (i ? "#" : "?") + "&]" + e + (t ? "=([^&]*)" : "($|&|=)")), n = location[i ? "hash" : "search"].match(a);
		return !!n && (!t || n[1])
	}

	function E(e) {
		_c.debug && console.log.apply(this, arguments)
	}

	function $(e, t) {
		e && !e.style.display != !t && (e.style.display = t ? "none" : null)
	}

	const j = (() => {
		function e(e) {
			return Y.local_storage ? localStorage.getItem(e) : null
		}

		function t(e, t) {
			"boolean" == typeof t && (t = t.toString());
			try {
				localStorage.setItem(e, t)
			} catch (e) {
				E("failed to write localstorage", e, "warn")
			}
		}

		return {
			get: t => {
				let i = e(t);
				return "true" === i || "false" !== i && i
			}, get_json: t => B(e(t)), set: function (e, i, a, n) {
				return Y.local_storage ? a && !i ? localStorage.removeItem(e) : n ? q(n).then((() => t(e, i))) : void t(e, i) : null
			}, remove: function (e) {
				if (Y.local_storage) return localStorage.removeItem(e)
			}, set_option: (e, t, i) => {
				if (Y.local_storage) return i === t ? localStorage.removeItem(e) : void localStorage.setItem(e, i ? "1" : "0")
			}, get_option: (t, i) => {
				const a = e(t);
				return a ? "1" === a : !!i
			}, bool: (e, i) => {
				if (Y.local_storage) return i ? t(e, !0) : localStorage.removeItem(e)
			}
		}
	})();

	function I(e) {
		var t = new XMLHttpRequest;
		return t.onreadystatechange = function () {
			if (4 == t.readyState) if (e.always && e.always(t), 200 == t.status) {
				var i = t.responseText, a = e.json_response, n = a ? (() => {
					try {
						return JSON.parse(i)
					} catch (e) {
						return a = !1, i
					}
				})() : i;
				if (a && n.error && "login" === n.error) return F.login();
				e.complete && e.complete(n, i, a);
				var o = !e.url && t.getResponseHeader("files-msg");
				o && E("XHR: files-msg: " + o)
			} else e.fail && e.fail(t)
		}, e.url != 'https://auth.photo.gallery/' && t.open(e.method || (e.params ? "POST" : "GET"), e.url || _c.script), e.params && t.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"), e.json_response && t.setRequestHeader("Accept", "application/json"), t.send(e.params || null), t
	}

	function T(e) {
		return _c.server_exif && e && e.exif && e.exif.Orientation && e.exif.Orientation > 4 && e.exif.Orientation < 9
	}

	function O(e) {
		return atob(e)
	}

	function S(e, t, i) {
		return Math.min(Math.max(i, e), t)
	}

	function Z() {
		if (Y.scrollbar_width) {
			var e = document.documentElement, t = window.innerWidth - e.clientWidth || (e.scrollHeight > e.clientHeight ? Y.scrollbar_width : 0);
			t != W.scrollbar_width && (t && (Y.scrollbar_width = t), W.scrollbar_width = t, document.documentElement.style.setProperty("--scrollbar-width", t + "px"))
		}
	}

	function R(e) {
		if (!(e.is_dir && e.is_readable && _c.folder_preview_image && _c.load_images && _c.image_resize_enabled)) return "";
		let t = _c.config.preview_image_cache ? `${_c.image_cache_hash}.${e.mtime}.${_c.menu_cache_hash || ""}` : Date.now();
		return `<img data-src="${_c.script}?action=preview&dir=${encodeURIComponent(e.path)}&${t}" class="files-folder-preview files-lazy" draggable="false">`
	}

	function D() {
		if (!Swal.isVisible()) return;
		let e = Swal.getContainer(), t = getComputedStyle(e), i = e.firstElementChild, a = getComputedStyle(i);
		(![t.top, t.right, t.bottom, t.left].every((e => 0 == e || "0px" == e)) || e.offsetWidth < window.innerWidth - 100 || i.offsetWidth < 100 || e.offsetHeight < window.innerHeight - 100 || i.offsetHeight < 100 || 1 != t.opacity || 1 != a.opacity || "none" == t.pointerEvents || "none" == a.pointerEvents || "none" == t.display || "none" == a.display || "visible" != t.visibility || "visible" != a.visibility || "fixed" != t.position || ["absolute", "fixed"].includes(a.position)) && document.body.remove()
	}

	var _h = {
		popup: (e, t, i, a, n) => {
			e && e.preventDefault(), t = Math.floor(Math.min(screen.width, t || 1e3)), i = Math.floor(Math.min(screen.height, i || 99999));
			var o = window.open(a, n || null, "toolbar=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,titlebar=no,width=" + t + ",height=" + i + ",top=" + Math.round(screen.height / 2 - i / 2) + ",left=" + Math.round(screen.width / 2 - t / 2));
			return window.focus && o.focus(), o
		}
	};

	function P(e, t) {
		e.className != t && (e.className = t)
	}

	function N(e) {
		var t = {};
		return e && e.split("&").forEach((e => {
			let [i, a] = e.split("=");
			t[i] = isNaN(a) ? a : +a
		})), t
	}

	function B(e, t) {
		if (e) try {
			let i = JSON.parse(e);
			return t ? i[t] : i
		} catch (e) {
			return
		}
	}

	const q = async e => new Promise((t => setTimeout(t, e))), F = (() => {
		const e = {duration: 2e3, gravity: "bottom", escapeMarkup: !1};
		let t = t => Toastify(Object.assign({}, e, t)).showToast();
		const i = (e, t) => U.get_svg_icon(e ? "check" : "cancel_circle") + '<span class="toastify-text">' + n(t) + "</span>", a = {
			toggle: (a, n, o) => t(Object.assign({text: i(a, n), className: "toastify-" + (a ? "success" : "danger"), duration: a ? e.duration : 3e3}, o || {})),
			loader: (e, i) => t({text: '<span class="toastify-text">' + e + "</span>" + (i ? '<span class="toastify-percent">' + U.get_svg_icon("tray_arrow_down") + '</span><span class="toastify-progress-bar"></span>' : ""), className: "toastify-loading", duration: -1})
		};
		return {
			toast: e => t(e),
			license: () => t({text: i(!1, "License required!"), className: "toastify-danger toastify-link", duration: 4e3, destination: O("aHR0cHM6Ly9saWNlbnNlLmZpbGVzLmdhbGxlcnkv"), newWindow: !0}),
			login: () => t({text: i(!1, J.get("login") + "!"), className: "toastify-danger toastify-link", duration: 4e3, destination: location.href}),
			refresh: e => t({text: i(!1, e + ". Please refresh browser!"), className: "toastify-danger toastify-link", duration: -1, destination: location.href}),
			toggle: a.toggle,
			demo: () => a.toggle(!1, "Not allowed in demo mode!"),
			loader: a.loader,
			progress: e => {
				let t = a.loader(e, !0);
				return {toast: t, counter: t.toastElement.children[1], progress_bar: t.toastElement.lastElementChild}
			}
		}
	})();
	_c.debug = z("debug") || 0 === location.host.indexOf("files.test"), _c.files = {}, E("_c", _c);
	const U = {}, W = {}, Q = {}, X = {main: _id("main"), topbar: _id("topbar"), topbar_top: _id("topbar-top"), files_container: _id("files-container"), files: _id("files"), topbar_info: _id("topbar-info"), filter_container: _id("search-container"), filter: _id("search")};
	var Y = {};

	function G(e, t) {
		if (t.mime1 && t.mime0 === e) return Y.hasOwnProperty(e) || (Y[e] = function () {
			if ("audio" === e && !window.Audio) return !1;
			var t = "audio" === e ? ["mpeg", "mp4", "x-aiff", "ogg", "x-m4a", "aac", "webm", "wave", "wav", "x-wav", "x-pn-wav", "flac"] : ["mp4", "webm", "ogg", "3gp", "m4v", "x-m4v"];
			try {
				var i = document.createElement(e);
				if (!i.canPlayType) return !1;
				var a = t.filter((function (t) {
					return i.canPlayType(e + "/" + t).replace(/no/, "")
				}));
				return !!a.length && a
			} catch (e) {
				return !1
			}
		}()), !(!Y[e] || !Y[e].includes(t.mime1)) && t.mime1
	}

	!function () {
		var e = Y, t = document, i = t.documentElement, a = navigator, n = a.userAgent, o = window;
		e.ua = n, e.explorer = /MSIE /.test(n) || /Trident\//.test(n);
		var s = !!(o.CSS && o.CSS.supports || o.supportsCSS);
		!e.explorer && s && CSS.supports("color", "var(--fake-var)") || (t.body.innerHTML = '<div class="alert alert-danger" role="alert"><strong>' + (e.explorer ? "Internet Explorer" : "This browser is") + ' not supported.</strong><br>Please use a modern browser like <a href="https://www.microsoft.com/en-us/windows/microsoft-edge" class="alert-link">Edge</a>, <a href="https://www.google.com/chrome/" class="alert-link">Chrome</a>, <a href="https://www.mozilla.org/firefox/" class="alert-link">Firefox</a>, <a href="https://www.opera.com/" class="alert-link">Opera</a> or <a href="https://www.apple.com/safari/" class="alert-link">Safari</a>.</div>', t.body.classList.remove("body-loading"), fail), e.local_storage = !!o.localStorage && (() => {
			try {
				var e = "_t";
				return o.localStorage.setItem(e, e), o.localStorage.removeItem(e), !0
			} catch (e) {
				return !1
			}
		})(), e.is_touch = "ontouchstart" in o || a.maxTouchPoints > 0 || a.msMaxTouchPoints > 0 || o.DocumentTouch && t instanceof DocumentTouch || o.matchMedia("(any-pointer: coarse)").matches, e.is_pointer = !e.is_touch || matchMedia("(pointer:fine)").matches, e.is_dual_input = e.is_touch && e.is_pointer, e.only_touch = e.is_touch && !e.is_pointer, e.only_pointer = !e.is_touch && e.is_pointer, e.PointerEvent = !!o.PointerEvent || a.msPointerEnabled, e.nav_langs = !(!a.languages || !a.languages.length) && a.languages || !!a.language && [a.language], e.pointer_events = !!("PointerEvent" in o) || a.msPointerEnabled, e.is_mac = /Mac|iPod|iPhone|iPad/.test(a.platform), e.c_key = e.is_mac ? "⌘" : "ctrl-", e.modKey = e.is_mac ? "metaKey" : "ctrlKey", e.scrollbar_width = e.is_pointer ? (() => {
			t.body.insertAdjacentHTML("beforeend", '<div class="scrollbar-test"></div>');
			var e = t.body.lastElementChild, a = () => e.offsetWidth - e.clientWidth;
			if (!a()) return e.remove(), 0;
			i.classList.add("has-scrollbars"), n.toLowerCase().indexOf("firefox") > -1 && (i.style.overflowY = "auto", q(0).then((() => i.style.removeProperty("overflow-y"))));
			var o = a();
			return e.remove(), o
		})() : 0, e.pixel_ratio = o.devicePixelRatio || 1, e.download = "download" in t.createElement("a"), e.clipboard = !(!t.queryCommandSupported || !t.queryCommandSupported("copy")), e.url = !("function" != typeof URL), e.fullscreen = screenfull.isEnabled, e.image_orientation = CSS.supports("image-orientation", "from-image"), e.browser_images = ["jpg", "jpeg", "png", "gif", "bmp", "svg", "svg+xml", "ico", "vnd.microsoft.icon", "x-icon"], (() => {
			const i = [["webp", "UklGRjoAAABXRUJQVlA4IC4AAACyAgCdASoCAAIALmk0mk0iIiIiIgBoSygABc6WWgAA/veff/0PP8bA//LwYAAA"], ["avif", "AAAAIGZ0eXBhdmlmAAAAAGF2aWZtaWYxbWlhZk1BMUIAAADybWV0YQAAAAAAAAAoaGRscgAAAAAAAAAAcGljdAAAAAAAAAAAAAAAAGxpYmF2aWYAAAAADnBpdG0AAAAAAAEAAAAeaWxvYwAAAABEAAABAAEAAAABAAABGgAAAB0AAAAoaWluZgAAAAAAAQAAABppbmZlAgAAAAABAABhdjAxQ29sb3IAAAAAamlwcnAAAABLaXBjbwAAABRpc3BlAAAAAAAAAAIAAAACAAAAEHBpeGkAAAAAAwgICAAAAAxhdjFDgQ0MAAAAABNjb2xybmNseAACAAIAAYAAAAAXaXBtYQAAAAAAAAABAAEEAQKDBAAAACVtZGF0EgAKCBgANogQEAwgMg8f8D///8WfhwB8+ErK42A="]];
			(a.vendor.match(/apple/i) || "").length > 0 && i.push(["tiff", "SUkqAAwAAAADIAACEwAAAQMAAQAAAAEAAAABAQMAAQAAAAIAAAACAQMAAQAAAAEAAAADAQMAAQAAAAQAAAAGAQMAAQAAAAAAAAAKAQMAAQAAAAIAAAANAQIACwAAAAYBAAARAQQAAQAAAAgAAAASAQMAAQAAAAEAAAAVAQMAAQAAAAEAAAAWAQMAAQAAAAIAAAAXAQQAAQAAAAQAAAAaAQUAAQAAAPYAAAAbAQUAAQAAAP4AAAAcAQMAAQAAAAEAAAAoAQMAAQAAAAIAAAApAQMAAgAAAAAAAQAxAQIARwAAABIBAABTAQMAAQAAAAEAAAAAAAAASAAAAAEAAABIAAAAAQAAAHRlbXAyLnRpZmYAAEdyYXBoaWNzTWFnaWNrIDEuNCBzbmFwc2hvdC0yMDIyMTIxMyBROCBodHRwOi8vd3d3LkdyYXBoaWNzTWFnaWNrLm9yZy8A"]);
			let n = j.get("files:tests:extended_images"), o = n ? n.split(",") : [], s = o.length;
			if (s && e.browser_images.push(...o), s >= i.length) return;
			let l = 1;
			const r = t => {
				t && [o, e.browser_images].forEach((e => e.push(t))), l++ === i.length && o.length > s && j.set("files:tests:extended_images", o)
			};
			let c = t.createElement("canvas");
			c.width = c.height = 1, i.forEach(((e, t) => {
				if (o.includes(e[0])) return r();
				if (0 == c.toDataURL(`image/${e[0]}`).indexOf(`data:image/${e[0]}`)) return r(e[0]);
				let i = new Image;
				i.onload = i.onerror = () => r(!(!i.height || 2 != i.height) && e[0]), i.src = `data:image/${e[0]};base64,${e[1]}`
			}))
		})(), e.history = !(!o.history || !history.pushState), e.history || (_c.history = !1), e.URLSearchParams = !!("URLSearchParams" in o), location.search && e.URLSearchParams && new URLSearchParams(location.search).forEach(((e, t) => {
			e && t.startsWith("--") && i.style.setProperty(t, e)
		})), e.max_texture_size = function () {
			if (o.WebGLRenderingContext) {
				var e = document.createElement("canvas");
				if (e && e.getContext) try {
					var t = e.getContext("webgl") || e.getContext("experimental-webgl");
					return !!t && t.getParameter(t.MAX_TEXTURE_SIZE)
				} catch (e) {
					return
				}
			}
		}() || 0
	}(), E("tests", Y), function () {
		if (Y.local_storage) {
			var e = z("clearall", !0), t = !e && z("clear", !0), i = e || t;
			if (U.clean_localstorage = function () {
				if (!i) {
					var e = Object.keys(localStorage);
					e.length && M(e, (function (e) {
						if (e.startsWith("files:menu:")) localStorage.removeItem(e); else if (e.startsWith("files:dir:")) if (e.startsWith("files:dir:" + _c.dirs_hash)) {
							if (_c.exists) {
								var t = e.split(":"), i = t[3];
								if (_c.menu_max_depth && i.split("/").length >= _c.menu_max_depth) return;
								var a = parseInt(t[4]);
								_c.dirs[i] && _c.dirs[i].mtime == a || localStorage.removeItem(e)
							}
						} else localStorage.removeItem(e)
					}))
				}
			}, i) {
				var a = 0;
				M(Object.keys(localStorage), (function (t) {
					(e && t.startsWith("files:") || t.startsWith("files:menu:") || t.startsWith("files:dir:")) && (localStorage.removeItem(t), a++)
				})), E(a + " localStorage items cleared")
			} else _c.menu_exists || U.clean_localstorage()
		}
	}(), function () {
		Y.local_storage && "clear_storage" === z("action", !0) && M(Object.keys(localStorage), (function (e) {
			(e.startsWith("files:config:") || e.startsWith("files:interface:")) && localStorage.removeItem(e)
		}));
		var e = {}, t = ["layout", "sort"];
		t.forEach((function (t) {
			e[t] = _c[t]
		})), U.set_config = function (t, i) {
			if (e.hasOwnProperty(t)) {
				if (_c[t] = i, e[t] === i) return j.remove("files:config:" + t);
				j.set("files:config:" + t, i)
			}
		};
		var i = j.get_json("files:options:" + _c.location_hash);
		i && (M(Object.keys(i), (function (e) {
			U.set_config(e, i[e])
		})), j.remove("files:options:" + _c.location_hash), j.remove("files:ls_options")), M(t, (function (e) {
			var t = j.get("files:config:" + e);
			if (null !== t) return t === _c[e] ? j.remove("files:config:" + e) : void (_c[e] = t)
		}))
	}();
	const K = e => e[0].toUpperCase() + e.slice(1), J = (() => {
		var e = !1, t = !1, i = _c.config && _c.config.lang || {},
			a = {ar: null, bg: null, cs: null, da: null, de: null, en: null, el: null, es: null, et: null, fi: null, fr: null, hu: null, id: null, it: null, ja: null, ko: null, nl: null, no: null, pl: null, pt: null, ro: null, ru: null, sk: null, sl: null, sv: null, th: null, tr: null, uk: null, zh: null},
			n = {ar: "sa", cs: "cz", da: "dk", el: "gr", en: "gb", et: "ee", ja: "jp", ko: "kr", sv: "se", sl: "si", uk: "ua", vi: "vn", zh: "cn"}, o = "object" == typeof _c.lang_custom ? _c.lang_custom : {};
		"object" == typeof i.langs && Object.keys(i.langs).forEach((e => {
			o[e] = Object.assign(o[e] || {}, i.langs[e])
		})), Object.keys(o).forEach((e => {
			o[e].flag && (n[e] = o[e].flag), a.hasOwnProperty(e) || (a[e] = o[e])
		}));
		var s = Object.keys(a).sort();
		if (Y.local_storage) {
			var l = j.get("files:version");
			l !== _c.version && j.set("files:version", _c.version), l && l !== _c.version && M(s, (function (e) {
				j.remove("files:lang:" + e)
			}))
		}
		var r = {}, c = {
			get: function (e, t) {
				var i = r[e] || e;
				return t ? K(i) : i
			}, set: function (e, t) {
				e.dataset.lang = t, e.textContent = this.get(t)
			}, span: function (e, t) {
				return `<span data-lang="${e}" class="no-pointer">${this.get(e, t)}</span>`
			}, dropdown: function () {
				var a = z("lang_menu", !0) || i.menu;
				if (a && "false" != a && "0" != a) {
					var o = Array.isArray(i.menu) ? i.menu : s;
					X.topbar_top.insertAdjacentHTML("beforeend", `<div id="change-lang" class="dropdown${e ? " dropdown-lang-loading" : ""}"><button type="button" class="button-icon button-lang" data-text="${g.split("-")[0]}"></button><div class="dropdown-menu dropdown-menu-topbar"><span class="dropdown-header" data-lang="language">${c.get("language")}</span><div class="dropdown-lang-items">${V(o, (function (e) {
						return `<button class="dropdown-item-lang${e === g ? " dropdown-lang-active" : ""}" data-action="${e}" style="background-image:url(${_c.assets + "flag-icons@6.6.4/flags/1x1/" + (n[e] || e)}.svg)"></button>`
					}))}</div></div>`);
					var l = (t = X.topbar_top.lastElementChild).firstElementChild, r = t.lastElementChild.lastElementChild, d = o.indexOf(g), u = d > -1 && r.children[d];
					U.dropdown(t, l), m(r, (function (e, t) {
						e !== g && (g = e, p(e), U.dayjs_locale(e), Q.uppy && U.uppy_locale(e), j.set("files:lang:current", e), l.dataset.text = e.split("-")[0], u && u.classList.remove("dropdown-lang-active"), (u = t.target).classList.add("dropdown-lang-active"))
					}))
				}
			}
		};

		function p(e) {
			if ("en" === e) return u({}, e);
			var t = a[e] || j.get_json("files:lang:" + e);
			return t ? u(t, e) : function (e) {
				d(!0), I({
					url: `${_c.assets}files.photo.gallery@${_c.version}/lang/${e}.json`, json_response: !0, complete: function (t, i, a) {
						d(), t && i && a || F.toggle(!1, e.toUpperCase()), j.set("files:lang:" + e, i), u(t, e)
					}, fail: function () {
						d()
					}
				})
			}(e)
		}

		function d(i) {
			e = !!i, t && t.classList.toggle("dropdown-lang-loading", e)
		}

		function u(e, t) {
			a[t] || (a[t] = Object.assign(e, o[t] || {})), r = e, _querya("[data-lang]").forEach((function (e) {
				var t = c.get(e.dataset.lang);
				return e.dataset.tooltip ? e.dataset.tooltip = t : e.title ? e.title = K(t) : void (e.textContent = t)
			})), X.filter && (X.filter.placeholder = c.get("filter"))
		}

		function h(e) {
			if (e) return "nb" === e || "nn" === e ? "no" : !!s.includes(e) && e
		}

		var f = z("lang", !0), _ = h(f);
		"reset" === f && j.remove("files:lang:current"), _ && j.set("files:lang:current", _);
		var g = _ || h(j.get("files:lang:current")) || function () {
			if (_c.lang_auto && Y.nav_langs) for (var e = 0; e < Y.nav_langs.length; e++) {
				var t = Y.nav_langs[e].toLowerCase().split("-");
				if ("tw" === t[1]) return;
				var i = h(t[0]);
				if (i) return i
			}
		}() || h(_c.lang_default) || "en";
		return "en" === g ? Object.assign(r, o.en || {}) : p(g), c
	})();
	!function () {
		const e = {codemirror: "codemirror@6.65.7", headroom: "headroom.js@0.12.0", uppy: "uppy@3.27.3", pannellum: "pannellum@2.5.6"};

		function t(e) {
			e.loading = !1, e.loaded = !0, M(e.complete, (function (e) {
				e()
			})), delete e.complete, delete e.src
		}

		function i(e, t, i) {
			var a = 0;
			M(e, (function (n) {
				!function (e, t, i) {
					var a = "js" == i.type || "js" == e.slice(-2), n = document.createElement(a ? "script" : "link");
					n[a ? "src" : "href"] = e.startsWith("http") ? e : _c.assets + e, t && (n.onload = t);
					i.error && (n.onerror = i.error);
					a ? document.body.appendChild(n) : (n.type = "text/css", n.rel = "stylesheet", document.head.insertBefore(n, _tag("link", document.head)[0]))
				}(n, (function () {
					++a === e.length && t && t()
				}), i)
			}))
		}

		Q.plugins = {
			codemirror: {
				src: [[e.codemirror + "/lib/codemirror.min.js", e.codemirror + "/lib/codemirror.css"], [e.codemirror + "/mode/meta.js", e.codemirror + "/addon/mode/loadmode.js", e.codemirror + "/addon/selection/active-line.js"]], complete: [function () {
					CodeMirror.modeURL = _c.assets + e.codemirror + "/mode/%N/%N.js"
				}]
			}, headroom: {src: [e.headroom + "/dist/headroom.min.js"]}, pannellum: {src: [e.pannellum + "/build/pannellum.min.js"]}, uppy: {src: [e.uppy + "/dist/uppy.min.js", e.uppy + "/dist/uppy.min.css"]}
		}, U.load_plugin = function (e, a, n) {
			Q.plugins[e] || (Q.plugins[e] = {});
			var o = n ? Object.assign(Q.plugins[e], n) : Q.plugins[e];
			if (o.loaded) a && a(); else if (o.loading) a && o.complete.push(a); else {
				o.loading = !0, o.complete || (o.complete = []), a && o.complete.push(a);
				var s = o.src && Array.isArray(o.src[0]);
				i(s ? o.src[0] : o.src, (function () {
					s ? i(o.src[1], (function () {
						t(o)
					}), o) : t(o)
				}), o)
			}
		}, document.addEventListener("keydown", (e => {
			e[Y.modKey] && "f" === e.key && "INPUT" !== e.target.nodeName && (e.preventDefault(), Q.headroom && Q.headroom.pin(), X.filter.focus())
		})), "scroll" === _c.topbar_sticky && getComputedStyle(X.topbar).position.match("sticky") && U.load_plugin("headroom", (function () {
			if (Headroom.cutsTheMustard) {
				var e = {tolerance: {down: 10, up: 20}, offset: X.topbar.clientHeight};
				Q.headroom = new Headroom(X.topbar, e), Q.headroom.init()
			}
		}))
	}();
	let ee = _c.menu_exists ? 2 : 1, te = !0;

	function ie() {
		if (ee--) return !ee && setTimeout(ie, 1e3);
		const e = `files:${O("bmVk")}`, t = location.hostname, i = j.get(e);
		if (!i || i != _c.md5 && O(i) != t) {
			var a = _c.x3_path && !_c.md5;
			if (!a || _c[O("dXNlcng=")] !== O("ZnA=")) return _c.md5 || a || !t || t.includes(".") ? !_c.md5 || "string" == typeof _c.md5 && /^[a-f0-9]{32}$/.test(_c.md5) ? void I({
				params: (_c.md5 ? "key=" + _c.md5 + "&" : "") + (a ? "app=1&domain=" : "app=2&host=") + encodeURI(t),
				url: O("aHR0cHM6Ly9hdXRoLnBob3RvLmdhbGxlcnkv"),
				json_response: !0,
				complete: (i, o, s) => {
					if (s && i && i.hasOwnProperty("status")) return i.status && 301 != i.status ? void (a || j.set(e, _c.md5 || btoa(t))) : n(_c.md5)
				}
			}) : n(!0) : n()
		}

		function n(e) {
			te = !1;
			const t = new RegExp(O("XkYxLVtBLVowLTldezR9LVtBLVowLTldezR9LVtBLVowLTldezR9LVtBLVowLTldezR9LVtBLVowLTldezR9LVtBLVowLTldezR9JA==")), i = e => {
				let i = e || Swal.getInput().value.trim();
				return i && t.test(i)
			};
			let a = "";
			["Remove this popup", "Upload, delete, move, copy, rename, zip and unzip", "Create new files and folders", "Mass download selected files and folders", "Advanced code and text editor", "Panorama photo viewer", "Dedicated support"].forEach((e => {
				a += `<div class="license-feature">${U.get_svg_icon("check")}${e}</div>`
			})), ue.prompt.fire({
				html: `<div class="license-container"><div class="license-header">${e ? '<div class="alert alert-danger" role="alert"><strong>Invalid license</strong><br>You have entered an invalid license key.</div>' : ""}<div class="license-title">Purchase a <a href="https://www.files.gallery/docs/license/" target="_blank" tabIndex="-1">license</a> to unlock features!</div><small><a href="https://www.files.gallery/" target="_blank" tabIndex="-1">www.files.gallery</a></small></div><div class="license-features">${a}</div><small>* After purchase, you will receive a license key by email.</small><a href="https://license.files.gallery/${location.search.includes("test=1") ? "?test=1" : ""}" target="_blank" class="button button-success" id="buy_button" tabIndex="-1">BUY LICENSE<span class="buy-button-price">$39.00</span></a></div>`,
				customClass: {confirmButton: "button button-success", cancelButton: "button button-secondary", input: "input", popup: "license-popup"},
				focusCancel: !0,
				inputAutoFocus: !1,
				showConfirmButton: !1,
				confirmButtonText: J.get("save"),
				cancelButtonText: "No thanks!",
				inputPlaceholder: "LICENSE-KEY",
				allowEnterKey: () => document.activeElement !== Swal.getInput() || i(),
				preConfirm: e => {
					if (!i(e)) return !1
				},
				didOpen: e => {
					const t = Swal.getConfirmButton(), a = Swal.getCancelButton(), n = Swal.getInput(), o = () => {
						let e = n.value.trim(), o = i(e);
						n[(e ? "set" : "remove") + "Attribute"]("aria-invalid", !o), t.style.display = o ? "inline-block" : "none", a.style.display = o ? "none" : "inline-block"
					};
					C(n, (() => o()), "input"), _id("buy_button").addEventListener("click", (e => {
						let t = _h.popup(e, 800, 1e3, e.currentTarget.href, "buy");
						window.addEventListener("message", (e => {
							e.source === t && /^https:\/\/.*(files|photo)\.gallery/.test(e.origin) && (Swal.getHtmlContainer().firstElementChild.innerHTML = `<div class="license-header"><div class="license-title">Thanks for purchasing!</div><p>Please ${e.data ? "save your license key" : "check your email"}.</p></div>`, e.data && (n.value = e.data.trim(), o()), window.focus(), n.focus())
						}), !1)
					})), setTimeout(D, 1e3)
				}
			}).then((e => {
				if (!e.isConfirmed || !e.value) return;
				let t = F.loader("Saving license");
				I({
					params: O("a2V5PQ==") + e.value, url: _c.script + "?action=save_license", json_response: !0, always: () => t.hideToast(), complete: (e, t, i) => {
						te = !(!i || !e.success), F.toggle(te, te ? "License saved!" : "Failed to save license key.")
					}, fail: e => F.toggle(!1, "Error")
				})
			}))
		}
	}

	!function () {
		function e(e, t, i) {
			return e.format(t) + (i ? '<span class="relative-time">' + e.fromNow() + "</span>" : "")
		}

		function t(t) {
			dayjs.locale(t), X.main.style.setProperty("--list-date-flex", dayjs().hour(22).date(22).format("L LT").length - 16), M(_tag("time"), (function (t) {
				if (t.dataset.time) {
					var i = dayjs.unix(t.dataset.time);
					t.innerHTML = e(i, t.dataset.format, t.children[0]), t.dataset.titleFormat && (t.title = i.format(t.dataset.titleFormat) + " — " + i.fromNow())
				}
			})), _c.current_dir && (_c.current_dir.html = !1)
		}

		function i(e) {
			U.load_plugin("dayjs_locale_" + e, (function () {
				t(e)
			}), {src: ["dayjs@1.11.12/locale/" + e + ".js"]})
		}

		U.get_time = function (t, i, a, n) {
			var o = dayjs.unix(t.mtime);
			return '<time datetime="' + o.format() + '" data-time="' + t.mtime + '" data-format="' + i + '"' + (a && Y.is_pointer ? ' title="' + o.format("LLLL") + " ~ " + o.fromNow() + '" data-title-format="LLLL"' : "") + ">" + e(o, i, n) + "</time>"
		}, dayjs.extend(dayjs_plugin_localizedFormat), dayjs.extend(dayjs_plugin_relativeTime), U.dayjs_locale = function (e) {
			if ("en" === e) return t(e);
			(e = n(e)) && i(e)
		};
		const a = ["af", "am", "ar-dz", "ar-iq", "ar-kw", "ar-ly", "ar-ma", "ar-sa", "ar-tn", "ar", "az", "be", "bg", "bi", "bm", "bn-bd", "bn", "bo", "br", "bs", "ca", "cs", "cv", "cy", "da", "de-at", "de-ch", "de", "dv", "el", "en-au", "en-ca", "en-gb", "en-ie", "en-il", "en-in", "en-nz", "en-sg", "en-tt", "en", "eo", "es-do", "es-mx", "es-pr", "es-us", "es", "et", "eu", "fa", "fi", "fo", "fr-ca", "fr-ch", "fr", "fy", "ga", "gd", "gl", "gom-latn", "gu", "he", "hi", "hr", "ht", "hu", "hy-am", "id", "is", "it-ch", "it", "ja", "jv", "ka", "kk", "km", "kn", "ko", "ku", "ky", "lb", "lo", "lt", "lv", "me", "mi", "mk", "ml", "mn", "mr", "ms-my", "ms", "mt", "my", "nb", "ne", "nl-be", "nl", "nn", "oc-lnc", "pa-in", "pl", "pt-br", "pt", "rn", "sd", "se", "si", "sk", "sl", "sq", "sr-cyrl", "sr", "ss", "sv-fi", "sv", "sw", "ta", "te", "tet", "tg", "th", "tk", "tl-ph", "tlh", "tr", "tzl", "tzm-latn", "tzm", "ug-cn", "uk", "ur", "uz-latn", "uz", "vi", "x-pseudo", "yo", "zh-cn", "zh-hk", "zh-tw", "zh", "rw", "ru", "ro"];

		function n(e) {
			if (e) return "no" === e || "nn" === e ? "nb" : !!a.includes(e) && e
		}

		var o = n(z("lang", !0)) || n(j.get("files:lang:current")) || function () {
			if (_c.lang_auto && Y.nav_langs) for (var e = 0; e < Y.nav_langs.length; e++) {
				var t = Y.nav_langs[e].toLowerCase(), i = n(t) || !!t.includes("-") && n(t.split("-")[0]);
				if (i) return i
			}
		}() || n(_c.lang_default) || "en";
		["en", "en-us"].includes(o) || i(o)
	}(), function () {
		const e = {
			bell: "M16,17H7V10.5C7,8 9,6 11.5,6C14,6 16,8 16,10.5M18,16V10.5C18,7.43 15.86,4.86 13,4.18V3.5A1.5,1.5 0 0,0 11.5,2A1.5,1.5 0 0,0 10,3.5V4.18C7.13,4.86 5,7.43 5,10.5V16L3,18V19H20V18M11.5,22A2,2 0 0,0 13.5,20H9.5A2,2 0 0,0 11.5,22Z",
			close: "M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z",
			close_thin: "M6.4 18.65 5.35 17.6l5.6-5.6-5.6-5.6L6.4 5.35l5.6 5.6 5.6-5.6 1.05 1.05-5.6 5.6 5.6 5.6-1.05 1.05-5.6-5.6Z",
			dots: "M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z",
			expand: "M10,21V19H6.41L10.91,14.5L9.5,13.09L5,17.59V14H3V21H10M14.5,10.91L19,6.41V10H21V3H14V5H17.59L13.09,9.5L14.5,10.91Z",
			collapse: "M19.5,3.09L15,7.59V4H13V11H20V9H16.41L20.91,4.5L19.5,3.09M4,13V15H7.59L3.09,19.5L4.5,20.91L9,16.41V20H11V13H4Z",
			magnify_plus: "M9,2A7,7 0 0,1 16,9C16,10.57 15.5,12 14.61,13.19L15.41,14H16L22,20L20,22L14,16V15.41L13.19,14.61C12,15.5 10.57,16 9,16A7,7 0 0,1 2,9A7,7 0 0,1 9,2M8,5V8H5V10H8V13H10V10H13V8H10V5H8Z",
			magnify_minus: "M9,2A7,7 0 0,1 16,9C16,10.57 15.5,12 14.61,13.19L15.41,14H16L22,20L20,22L14,16V15.41L13.19,14.61C12,15.5 10.57,16 9,16A7,7 0 0,1 2,9A7,7 0 0,1 9,2M5,8V10H13V8H5Z",
			chevron_left: "M15.41,16.58L10.83,12L15.41,7.41L14,6L8,12L14,18L15.41,16.58Z",
			chevron_right: "M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z",
			chevron_up: "M7.41,15.41L12,10.83L16.59,15.41L18,14L12,8L6,14L7.41,15.41Z",
			chevron_down: "M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z",
			arrow_left: "M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z",
			arrow_right: "M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z",
			link: "M3.9,12C3.9,10.29 5.29,8.9 7,8.9H11V7H7A5,5 0 0,0 2,12A5,5 0 0,0 7,17H11V15.1H7C5.29,15.1 3.9,13.71 3.9,12M8,13H16V11H8V13M17,7H13V8.9H17C18.71,8.9 20.1,10.29 20.1,12C20.1,13.71 18.71,15.1 17,15.1H13V17H17A5,5 0 0,0 22,12A5,5 0 0,0 17,7Z",
			logout: "M14.08,15.59L16.67,13H7V11H16.67L14.08,8.41L15.5,7L20.5,12L15.5,17L14.08,15.59M19,3A2,2 0 0,1 21,5V9.67L19,7.67V5H5V19H19V16.33L21,14.33V19A2,2 0 0,1 19,21H5C3.89,21 3,20.1 3,19V5C3,3.89 3.89,3 5,3H19Z",
			download: "M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z",
			tray_arrow_down: "M2 12H4V17H20V12H22V17C22 18.11 21.11 19 20 19H4C2.9 19 2 18.11 2 17V12M12 15L17.55 9.54L16.13 8.13L13 11.25V2H11V11.25L7.88 8.13L6.46 9.55L12 15Z",
			tray_arrow_up: "M2 12H4V17H20V12H22V17C22 18.11 21.11 19 20 19H4C2.9 19 2 18.11 2 17V12M12 2L6.46 7.46L7.88 8.88L11 5.75V15H13V5.75L16.13 8.88L17.55 7.45L12 2Z",
			content_copy: "M19,21H8V7H19M19,5H8A2,2 0 0,0 6,7V21A2,2 0 0,0 8,23H19A2,2 0 0,0 21,21V7A2,2 0 0,0 19,5M16,1H4A2,2 0 0,0 2,3V17H4V3H16V1Z",
			content_duplicate: "M11,17H4A2,2 0 0,1 2,15V3A2,2 0 0,1 4,1H16V3H4V15H11V13L15,16L11,19V17M19,21V7H8V13H6V7A2,2 0 0,1 8,5H19A2,2 0 0,1 21,7V21A2,2 0 0,1 19,23H8A2,2 0 0,1 6,21V19H8V21H19Z",
			delete_outline: "M9,3V4H4V6H5V19A2,2 0 0,0 7,21H17A2,2 0 0,0 19,19V6H20V4H15V3H9M7,6H17V19H7V6M9,8V17H11V8H9M13,8V17H15V8H13Z",
			rename_outline: "M15 16L11 20H21V16H15M12.06 7.19L3 16.25V20H6.75L15.81 10.94L12.06 7.19M5.92 18H5V17.08L12.06 10L13 10.94L5.92 18M18.71 8.04C19.1 7.65 19.1 7 18.71 6.63L16.37 4.29C16.17 4.09 15.92 4 15.66 4C15.41 4 15.15 4.1 14.96 4.29L13.13 6.12L16.88 9.87L18.71 8.04Z",
			close_thick: "M20 6.91L17.09 4L12 9.09L6.91 4L4 6.91L9.09 12L4 17.09L6.91 20L12 14.91L17.09 20L20 17.09L14.91 12L20 6.91Z",
			plus_circle_multiple_outline: "M16,8H14V11H11V13H14V16H16V13H19V11H16M2,12C2,9.21 3.64,6.8 6,5.68V3.5C2.5,4.76 0,8.09 0,12C0,15.91 2.5,19.24 6,20.5V18.32C3.64,17.2 2,14.79 2,12M15,3C10.04,3 6,7.04 6,12C6,16.96 10.04,21 15,21C19.96,21 24,16.96 24,12C24,7.04 19.96,3 15,3M15,19C11.14,19 8,15.86 8,12C8,8.14 11.14,5 15,5C18.86,5 22,8.14 22,12C22,15.86 18.86,19 15,19Z",
			upload: "M9,16V10H5L12,3L19,10H15V16H9M5,20V18H19V20H5Z",
			clipboard: "M19,3H14.82C14.4,1.84 13.3,1 12,1C10.7,1 9.6,1.84 9.18,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M12,3A1,1 0 0,1 13,4A1,1 0 0,1 12,5A1,1 0 0,1 11,4A1,1 0 0,1 12,3M7,7H17V5H19V19H5V5H7V7M7.5,13.5L9,12L11,14L15.5,9.5L17,11L11,17L7.5,13.5Z",
			save_edit: "M10,19L10.14,18.86C8.9,18.5 8,17.36 8,16A3,3 0 0,1 11,13C12.36,13 13.5,13.9 13.86,15.14L20,9V7L16,3H4C2.89,3 2,3.9 2,5V19A2,2 0 0,0 4,21H10V19M4,5H14V9H4V5M20.04,12.13C19.9,12.13 19.76,12.19 19.65,12.3L18.65,13.3L20.7,15.35L21.7,14.35C21.92,14.14 21.92,13.79 21.7,13.58L20.42,12.3C20.31,12.19 20.18,12.13 20.04,12.13M18.07,13.88L12,19.94V22H14.06L20.12,15.93L18.07,13.88Z",
			theme_contrast: "M12 9c1.65 0 3 1.35 3 3s-1.35 3-3 3-3-1.35-3-3 1.35-3 3-3m0-2c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM2 13h2c.55 0 1-.45 1-1s-.45-1-1-1H2c-.55 0-1 .45-1 1s.45 1 1 1zm18 0h2c.55 0 1-.45 1-1s-.45-1-1-1h-2c-.55 0-1 .45-1 1s.45 1 1 1zM11 2v2c0 .55.45 1 1 1s1-.45 1-1V2c0-.55-.45-1-1-1s-1 .45-1 1zm0 18v2c0 .55.45 1 1 1s1-.45 1-1v-2c0-.55-.45-1-1-1s-1 .45-1 1zM5.99 4.58c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0s.39-1.03 0-1.41L5.99 4.58zm12.37 12.37c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0 .39-.39.39-1.03 0-1.41l-1.06-1.06zm1.06-10.96c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06zM7.05 18.36c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06z",
			theme_light: "m6.76 4.84-1.8-1.79-1.41 1.41 1.79 1.79 1.42-1.41zM4 10.5H1v2h3v-2zm9-9.95h-2V3.5h2V.55zm7.45 3.91-1.41-1.41-1.79 1.79 1.41 1.41 1.79-1.79zm-3.21 13.7 1.79 1.8 1.41-1.41-1.8-1.79-1.4 1.4zM20 10.5v2h3v-2h-3zm-8-5c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm-1 16.95h2V19.5h-2v2.95zm-7.45-3.91 1.41 1.41 1.79-1.8-1.41-1.41-1.79 1.8z",
			theme_dark: "M9.37 5.51c-.18.64-.27 1.31-.27 1.99 0 4.08 3.32 7.4 7.4 7.4.68 0 1.35-.09 1.99-.27C17.45 17.19 14.93 19 12 19c-3.86 0-7-3.14-7-7 0-2.93 1.81-5.45 4.37-6.49zM12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9c0-.46-.04-.92-.1-1.36-.98 1.37-2.58 2.26-4.4 2.26-2.98 0-5.4-2.42-5.4-5.4 0-1.81.89-3.42 2.26-4.4-.44-.06-.9-.1-1.36-.1z",
			marker: "M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z",
			info: "M11,9H13V7H11M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M11,17H13V11H11V17Z",
			folder: "M4 5v14h16V7h-8.414l-2-2H4zm8.414 0H21a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h7.414l2 2z",
			folder_plus: "M13 9h-2v3H8v2h3v3h2v-3h3v-2h-3z",
			folder_plus_outline: "M13 19C13 19.34 13.04 19.67 13.09 20H4C2.9 20 2 19.11 2 18V6C2 4.89 2.89 4 4 4H10L12 6H20C21.1 6 22 6.89 22 8V13.81C21.39 13.46 20.72 13.22 20 13.09V8H4V18H13.09C13.04 18.33 13 18.66 13 19M20 18V15H18V18H15V20H18V23H20V20H23V18H20Z",
			file_document_plus_outline: "M23 18H20V15H18V18H15V20H18V23H20V20H23M6 2C4.89 2 4 2.9 4 4V20C4 21.11 4.89 22 6 22H13.81C13.45 21.38 13.2 20.7 13.08 20H6V4H13V9H18V13.08C18.33 13.03 18.67 13 19 13C19.34 13 19.67 13.03 20 13.08V8L14 2M8 12V14H16V12M8 16V18H13V16Z",
			folder_minus: "M7.874 12h8v2h-8z",
			folder_forbid: "M22 11.255a6.972 6.972 0 0 0-2-.965V7h-8.414l-2-2H4v14h7.29a6.96 6.96 0 0 0 .965 2H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h7.414l2 2H21a1 1 0 0 1 1 1v5.255zM18 22a5 5 0 1 1 0-10a5 5 0 0 1 0 10zm-1.293-2.292a3 3 0 0 0 4.001-4.001l-4.001 4zm-1.415-1.415l4.001-4a3 3 0 0 0-4.001 4.001z",
			folder_link: "M22 13h-2V7h-8.414l-2-2H4v14h9v2H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h7.414l2 2H21a1 1 0 0 1 1 1v7zm-4 4v-3.5l5 4.5l-5 4.5V19h-3v-2h3z",
			folder_wrench: "M13.03 20H4C2.9 20 2 19.11 2 18V6C2 4.89 2.89 4 4 4H10L12 6H20C21.1 6 22 6.89 22 8V17.5L20.96 16.44C20.97 16.3 21 16.15 21 16C21 13.24 18.76 11 16 11S11 13.24 11 16C11 17.64 11.8 19.09 13.03 20M22.87 21.19L18.76 17.08C19.17 16.04 18.94 14.82 18.08 13.97C17.18 13.06 15.83 12.88 14.74 13.38L16.68 15.32L15.33 16.68L13.34 14.73C12.8 15.82 13.05 17.17 13.93 18.08C14.79 18.94 16 19.16 17.05 18.76L21.16 22.86C21.34 23.05 21.61 23.05 21.79 22.86L22.83 21.83C23.05 21.65 23.05 21.33 22.87 21.19Z",
			folder_cog_outline: "M4 4C2.89 4 2 4.89 2 6V18C2 19.11 2.9 20 4 20H12V18H4V8H20V12H22V8C22 6.89 21.1 6 20 6H12L10 4M18 14C17.87 14 17.76 14.09 17.74 14.21L17.55 15.53C17.25 15.66 16.96 15.82 16.7 16L15.46 15.5C15.35 15.5 15.22 15.5 15.15 15.63L14.15 17.36C14.09 17.47 14.11 17.6 14.21 17.68L15.27 18.5C15.25 18.67 15.24 18.83 15.24 19C15.24 19.17 15.25 19.33 15.27 19.5L14.21 20.32C14.12 20.4 14.09 20.53 14.15 20.64L15.15 22.37C15.21 22.5 15.34 22.5 15.46 22.5L16.7 22C16.96 22.18 17.24 22.35 17.55 22.47L17.74 23.79C17.76 23.91 17.86 24 18 24H20C20.11 24 20.22 23.91 20.24 23.79L20.43 22.47C20.73 22.34 21 22.18 21.27 22L22.5 22.5C22.63 22.5 22.76 22.5 22.83 22.37L23.83 20.64C23.89 20.53 23.86 20.4 23.77 20.32L22.7 19.5C22.72 19.33 22.74 19.17 22.74 19C22.74 18.83 22.73 18.67 22.7 18.5L23.76 17.68C23.85 17.6 23.88 17.47 23.82 17.36L22.82 15.63C22.76 15.5 22.63 15.5 22.5 15.5L21.27 16C21 15.82 20.73 15.65 20.42 15.53L20.23 14.21C20.22 14.09 20.11 14 20 14M19 17.5C19.83 17.5 20.5 18.17 20.5 19C20.5 19.83 19.83 20.5 19 20.5C18.16 20.5 17.5 19.83 17.5 19C17.5 18.17 18.17 17.5 19 17.5Z",
			folder_open: "M12.414 5H21a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h7.414l2 2zM4 5v14h16V7h-8.414l-2-2H4zm8 7V9l4 4l-4 4v-3H8v-2h4z",
			folder_move_outline: "M20 18H4V8H20V18M12 6L10 4H4C2.9 4 2 4.89 2 6V18C2 19.11 2.9 20 4 20H20C21.11 20 22 19.11 22 18V8C22 6.9 21.11 6 20 6H12M11 14V12H15V9L19 13L15 17V14H11Z",
			alert_circle_outline: "M11,15H13V17H11V15M11,7H13V13H11V7M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20Z",
			date: "M19 3H18V1H16V3H8V1H6V3H5C3.89 3 3 3.9 3 5V19C3 20.11 3.9 21 5 21H19C20.11 21 21 20.11 21 19V5C21 3.9 20.11 3 19 3M19 19H5V9H19V19M19 7H5V5H19V7Z",
			camera: "M20,4H16.83L15,2H9L7.17,4H4A2,2 0 0,0 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6A2,2 0 0,0 20,4M20,18H4V6H8.05L9.88,4H14.12L15.95,6H20V18M12,7A5,5 0 0,0 7,12A5,5 0 0,0 12,17A5,5 0 0,0 17,12A5,5 0 0,0 12,7M12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15Z",
			cellphone: "M17,19H7V5H17M17,1H7C5.89,1 5,1.89 5,3V21A2,2 0 0,0 7,23H17A2,2 0 0,0 19,21V3C19,1.89 18.1,1 17,1Z",
			plus: "M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z",
			minus: "M19,13H5V11H19V13Z",
			menu: "M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z",
			menu_back: "M5,13L9,17L7.6,18.42L1.18,12L7.6,5.58L9,7L5,11H21V13H5M21,6V8H11V6H21M21,16V18H11V16H21Z",
			gif: "M11.5 9H13v6h-1.5zM9 9H6c-.6 0-1 .5-1 1v4c0 .5.4 1 1 1h3c.6 0 1-.5 1-1v-2H8.5v1.5h-2v-3H10V10c0-.5-.4-1-1-1zM19 10.5V9h-4.5v6H16v-2h2v-1.5h-2v-1z",
			rotate_right: "M16.89,15.5L18.31,16.89C19.21,15.73 19.76,14.39 19.93,13H17.91C17.77,13.87 17.43,14.72 16.89,15.5M13,17.9V19.92C14.39,19.75 15.74,19.21 16.9,18.31L15.46,16.87C14.71,17.41 13.87,17.76 13,17.9M19.93,11C19.76,9.61 19.21,8.27 18.31,7.11L16.89,8.53C17.43,9.28 17.77,10.13 17.91,11M15.55,5.55L11,1V4.07C7.06,4.56 4,7.92 4,12C4,16.08 7.05,19.44 11,19.93V17.91C8.16,17.43 6,14.97 6,12C6,9.03 8.16,6.57 11,6.09V10L15.55,5.55Z",
			motion_play_outline: "M10 16.5L16 12L10 7.5M22 12C22 6.46 17.54 2 12 2C10.83 2 9.7 2.19 8.62 2.56L9.32 4.5C10.17 4.16 11.06 3.97 12 3.97C16.41 3.97 20.03 7.59 20.03 12C20.03 16.41 16.41 20.03 12 20.03C7.59 20.03 3.97 16.41 3.97 12C3.97 11.06 4.16 10.12 4.5 9.28L2.56 8.62C2.19 9.7 2 10.83 2 12C2 17.54 6.46 22 12 22C17.54 22 22 17.54 22 12M5.47 3.97C6.32 3.97 7 4.68 7 5.47C7 6.32 6.32 7 5.47 7C4.68 7 3.97 6.32 3.97 5.47C3.97 4.68 4.68 3.97 5.47 3.97Z",
			motion_pause_outline: "M22 12C22 6.46 17.54 2 12 2C10.83 2 9.7 2.19 8.62 2.56L9.32 4.5C10.17 4.16 11.06 3.97 12 3.97C16.41 3.97 20.03 7.59 20.03 12C20.03 16.41 16.41 20.03 12 20.03C7.59 20.03 3.97 16.41 3.97 12C3.97 11.06 4.16 10.12 4.5 9.28L2.56 8.62C2.19 9.7 2 10.83 2 12C2 17.54 6.46 22 12 22C17.54 22 22 17.54 22 12M5.47 7C4.68 7 3.97 6.32 3.97 5.47C3.97 4.68 4.68 3.97 5.47 3.97C6.32 3.97 7 4.68 7 5.47C7 6.32 6.32 7 5.47 7M9 9H11V15H9M13 9H15V15H13",
			panorama_variant: "M20.7 4.1C18.7 4.8 15.9 5.5 12 5.5C8.1 5.5 5.1 4.7 3.3 4.1C2.7 3.8 2 4.3 2 5V19C2 19.7 2.7 20.2 3.3 20C5.4 19.3 8.1 18.5 12 18.5C15.9 18.5 18.7 19.3 20.7 20C21.4 20.2 22 19.7 22 19V5C22 4.3 21.3 3.8 20.7 4.1M12 15C9.7 15 7.5 15.1 5.5 15.4L9.2 11L11.2 13.4L14 10L18.5 15.4C16.5 15.1 14.3 15 12 15Z",
			sort_name_asc: "M9.25 5L12.5 1.75L15.75 5H9.25M8.89 14.3H6L5.28 17H2.91L6 7H9L12.13 17H9.67L8.89 14.3M6.33 12.68H8.56L7.93 10.56L7.67 9.59L7.42 8.63H7.39L7.17 9.6L6.93 10.58L6.33 12.68M13.05 17V15.74L17.8 8.97V8.91H13.5V7H20.73V8.34L16.09 15V15.08H20.8V17H13.05Z",
			sort_name_desc: "M15.75 19L12.5 22.25L9.25 19H15.75M8.89 14.3H6L5.28 17H2.91L6 7H9L12.13 17H9.67L8.89 14.3M6.33 12.68H8.56L7.93 10.56L7.67 9.59L7.42 8.63H7.39L7.17 9.6L6.93 10.58L6.33 12.68M13.05 17V15.74L17.8 8.97V8.91H13.5V7H20.73V8.34L16.09 15V15.08H20.8V17H13.05Z",
			sort_kind_asc: "M3 11H15V13H3M3 18V16H21V18M3 6H9V8H3Z",
			sort_kind_desc: "M3,13H15V11H3M3,6V8H21V6M3,18H9V16H3V18Z",
			sort_size_asc: "M10,13V11H18V13H10M10,19V17H14V19H10M10,7V5H22V7H10M6,17H8.5L5,20.5L1.5,17H4V7H1.5L5,3.5L8.5,7H6V17Z",
			sort_size_desc: "M10,13V11H18V13H10M10,19V17H14V19H10M10,7V5H22V7H10M6,17H8.5L5,20.5L1.5,17H4V7H1.5L5,3.5L8.5,7H6V17Z",
			sort_date_asc: "M7.78 7C9.08 7.04 10 7.53 10.57 8.46C11.13 9.4 11.41 10.56 11.39 11.95C11.4 13.5 11.09 14.73 10.5 15.62C9.88 16.5 8.95 16.97 7.71 17C6.45 16.96 5.54 16.5 4.96 15.56C4.38 14.63 4.09 13.45 4.09 12S4.39 9.36 5 8.44C5.59 7.5 6.5 7.04 7.78 7M7.75 8.63C7.31 8.63 6.96 8.9 6.7 9.46C6.44 10 6.32 10.87 6.32 12C6.31 13.15 6.44 14 6.69 14.54C6.95 15.1 7.31 15.37 7.77 15.37C8.69 15.37 9.16 14.24 9.17 12C9.17 9.77 8.7 8.65 7.75 8.63M13.33 17V15.22L13.76 15.24L14.3 15.22L15.34 15.03C15.68 14.92 16 14.78 16.26 14.58C16.59 14.35 16.86 14.08 17.07 13.76C17.29 13.45 17.44 13.12 17.53 12.78L17.5 12.77C17.05 13.19 16.38 13.4 15.47 13.41C14.62 13.4 13.91 13.15 13.34 12.65S12.5 11.43 12.46 10.5C12.47 9.5 12.81 8.69 13.47 8.03C14.14 7.37 15 7.03 16.12 7C17.37 7.04 18.29 7.45 18.88 8.24C19.47 9 19.76 10 19.76 11.19C19.75 12.15 19.61 13 19.32 13.76C19.03 14.5 18.64 15.13 18.12 15.64C17.66 16.06 17.11 16.38 16.47 16.61C15.83 16.83 15.12 16.96 14.34 17H13.33M16.06 8.63C15.65 8.64 15.32 8.8 15.06 9.11C14.81 9.42 14.68 9.84 14.68 10.36C14.68 10.8 14.8 11.16 15.03 11.46C15.27 11.77 15.63 11.92 16.11 11.93C16.43 11.93 16.7 11.86 16.92 11.74C17.14 11.61 17.3 11.46 17.41 11.28C17.5 11.17 17.53 10.97 17.53 10.71C17.54 10.16 17.43 9.69 17.2 9.28C16.97 8.87 16.59 8.65 16.06 8.63M9.25 5L12.5 1.75L15.75 5H9.25",
			sort_date_desc: "M7.78 7C9.08 7.04 10 7.53 10.57 8.46C11.13 9.4 11.41 10.56 11.39 11.95C11.4 13.5 11.09 14.73 10.5 15.62C9.88 16.5 8.95 16.97 7.71 17C6.45 16.96 5.54 16.5 4.96 15.56C4.38 14.63 4.09 13.45 4.09 12S4.39 9.36 5 8.44C5.59 7.5 6.5 7.04 7.78 7M7.75 8.63C7.31 8.63 6.96 8.9 6.7 9.46C6.44 10 6.32 10.87 6.32 12C6.31 13.15 6.44 14 6.69 14.54C6.95 15.1 7.31 15.37 7.77 15.37C8.69 15.37 9.16 14.24 9.17 12C9.17 9.77 8.7 8.65 7.75 8.63M13.33 17V15.22L13.76 15.24L14.3 15.22L15.34 15.03C15.68 14.92 16 14.78 16.26 14.58C16.59 14.35 16.86 14.08 17.07 13.76C17.29 13.45 17.44 13.12 17.53 12.78L17.5 12.77C17.05 13.19 16.38 13.4 15.47 13.41C14.62 13.4 13.91 13.15 13.34 12.65S12.5 11.43 12.46 10.5C12.47 9.5 12.81 8.69 13.47 8.03C14.14 7.37 15 7.03 16.12 7C17.37 7.04 18.29 7.45 18.88 8.24C19.47 9 19.76 10 19.76 11.19C19.75 12.15 19.61 13 19.32 13.76C19.03 14.5 18.64 15.13 18.12 15.64C17.66 16.06 17.11 16.38 16.47 16.61C15.83 16.83 15.12 16.96 14.34 17H13.33M16.06 8.63C15.65 8.64 15.32 8.8 15.06 9.11C14.81 9.42 14.68 9.84 14.68 10.36C14.68 10.8 14.8 11.16 15.03 11.46C15.27 11.77 15.63 11.92 16.11 11.93C16.43 11.93 16.7 11.86 16.92 11.74C17.14 11.61 17.3 11.46 17.41 11.28C17.5 11.17 17.53 10.97 17.53 10.71C17.54 10.16 17.43 9.69 17.2 9.28C16.97 8.87 16.59 8.65 16.06 8.63M15.75 19L12.5 22.25L9.25 19H15.75Z",
			sort_shuffle_asc: "M17,3L22.25,7.5L17,12L22.25,16.5L17,21V18H14.26L11.44,15.18L13.56,13.06L15.5,15H17V12L17,9H15.5L6.5,18H2V15H5.26L14.26,6H17V3M2,6H6.5L9.32,8.82L7.2,10.94L5.26,9H2V6Z",
			filesize: "M3,13H15V11H3M3,6V8H21V6M3,18H9V16H3V18Z",
			layout_list: "M8 5h13v2H7V5Zm-5 0h2v2H3Zm0 6h2v2H3Zm0 6h2v2H3ZM8 11h13v2H7v-2Zm0 6h13v2H7v-2Z",
			layout_imagelist: "M3,4H7V8H3V4M9,5V7H21V5H9M3,10H7V14H3V10M9,11V13H21V11H9M3,16H7V20H3V16M9,17V19H21V17H9",
			layout_blocks: "M4 11h6A1 1 0 0011 10v-6A1 1 0 0010 3h-6A1 1 0 003 4V10A1 1 0 004 11zM4 21h6a1 1 0 001-1v-6a1 1 0 00-1-1H4a1 1 0 00-1 1v6a1 1 0 001 1zM17 8H13V10H17M13 4V6H21V4M13 20H17V18H13M13 16H21V14H13",
			layout_grid: "M4 11h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1zm10 0h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1zM4 21h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1zm10 0h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1z",
			layout_rows: "M3 4v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1zm9 17h8c.55 0 1-.45 1-1v-6c0-.55-.45-1-1-1H12c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1zm-8 0h4c.55 0 1-.45 1-1v-6c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1z",
			layout_columns: "M4 13h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1zm0 8h6c.55 0 1-.45 1-1v-4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1zm10 0h6c.55 0 1-.45 1-1v-8c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1zM13 4v4c0 .55.45 1 1 1h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1z",
			lock_outline: "M12,17C10.89,17 10,16.1 10,15C10,13.89 10.89,13 12,13A2,2 0 0,1 14,15A2,2 0 0,1 12,17M18,20V10H6V20H18M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V10C4,8.89 4.89,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z",
			lock_open_outline: "M18,20V10H6V20H18M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V10A2,2 0 0,1 6,8H15V6A3,3 0 0,0 12,3A3,3 0 0,0 9,6H7A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,17A2,2 0 0,1 10,15A2,2 0 0,1 12,13A2,2 0 0,1 14,15A2,2 0 0,1 12,17Z",
			open_in_new: "m15 5l-1.41 1.41L15 7.83L17.17 10H8c-2.76 0-5 2.24-5 5v4h2v-4c0-1.65 1.35-3 3-3h9.17L15 14.17l-1.41 1.41L15 17l6-6l-6-6z",
			play: "M8,5.14V19.14L19,12.14L8,5.14Z",
			pause: "M14,19H18V5H14M6,19H10V5H6V19Z",
			menu_down: "M7,13L12,18L17,13H7Z",
			menu_up: "M7,12L12,7L17,12H7Z",
			home: "M20 6H12L10 4H4A2 2 0 0 0 2 6V18A2 2 0 0 0 4 20H20A2 2 0 0 0 22 18V8A2 2 0 0 0 20 6M17 13V17H15V14H13V17H11V13H9L14 9L19 13Z",
			image_search_outline: "M15.5,9C16.2,9 16.79,8.76 17.27,8.27C17.76,7.79 18,7.2 18,6.5C18,5.83 17.76,5.23 17.27,4.73C16.79,4.23 16.2,4 15.5,4C14.83,4 14.23,4.23 13.73,4.73C13.23,5.23 13,5.83 13,6.5C13,7.2 13.23,7.79 13.73,8.27C14.23,8.76 14.83,9 15.5,9M19.31,8.91L22.41,12L21,13.41L17.86,10.31C17.08,10.78 16.28,11 15.47,11C14.22,11 13.16,10.58 12.3,9.7C11.45,8.83 11,7.77 11,6.5C11,5.27 11.45,4.2 12.33,3.33C13.2,2.45 14.27,2 15.5,2C16.77,2 17.83,2.45 18.7,3.33C19.58,4.2 20,5.27 20,6.5C20,7.33 19.78,8.13 19.31,8.91M16.5,18H5.5L8.25,14.5L10.22,16.83L12.94,13.31L16.5,18M18,13L20,15V20C20,20.55 19.81,21 19.41,21.4C19,21.79 18.53,22 18,22H4C3.45,22 3,21.79 2.6,21.4C2.21,21 2,20.55 2,20V6C2,5.47 2.21,5 2.6,4.59C3,4.19 3.45,4 4,4H9.5C9.2,4.64 9.03,5.31 9,6H4V20H18V13Z",
			search: "M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z",
			default: "M14 10V4.5L19 10M5 3C3.89 3 3 3.89 3 5V19A2 2 0 005 21H19A2 2 0 0021 19V9L15 3H5Z",
			file_copy: "M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12zm-1 4 6 6v10c0 1.1-.9 2-2 2H7.99C6.89 23 6 22.1 6 21l.01-14c0-1.1.89-2 1.99-2zm-1 7h5.5L14 6.5z",
			application: "M19 3H5a2 2 0 00-2 2v2h18V5a2 2 0 00-2-2ZM6 6a1 1 0 111-1 1 1 0 01-1 1Zm3 0a1 1 0 111-1 1.003 1.003 0 01-1 1Zm12 6V8H3v11a2 2 0 002 2h14a2 2 0 002-2Z",
			archive: "M14,17H12V15H10V13H12V15H14M14,9H12V11H14V13H12V11H10V9H12V7H10V5H12V7H14M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z",
			audio: "M16,9H13V14.5A2.5,2.5 0 0,1 10.5,17A2.5,2.5 0 0,1 8,14.5A2.5,2.5 0 0,1 10.5,12C11.07,12 11.58,12.19 12,12.5V7H16M19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3Z",
			cd: "M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9Z",
			code: "m9.6 15.6l1.4-1.425L8.825 12L11 9.825L9.6 8.4L6 12Zm4.8 0L18 12l-3.6-3.6L13 9.825L15.175 12L13 14.175ZM5 21q-.825 0-1.413-.587Q3 19.825 3 19V5q0-.825.587-1.413Q4.175 3 5 3h14q.825 0 1.413.587Q21 4.175 21 5v14q0 .825-.587 1.413Q19.825 21 19 21Z",
			excel: "M19 3H5C3.89 3 3 3.89 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.89 20.1 3 19 3M9 18H6V16H9V18M9 15H6V13H9V15M9 12H6V10H9V12M13 18H10V16H13V18M13 15H10V13H13V15M13 12H10V10H13V12Z",
			font: "M9.837 13.05h3.726L11.7 8.082zM18.9 2.7H4.5c-.99 0-1.8.81-1.8 1.8v14.4c0 .99.81 1.8 1.8 1.8h14.4c.99 0 1.8-.81 1.8-1.8V4.5c0-.99-.81-1.8-1.8-1.8zm-3.645 14.85-1.026-2.7H9.153l-1.008 2.7H6.264l4.599-11.7h1.674l4.599 11.7h-1.881z",
			image: "M8.5,13.5L11,16.5L14.5,12L19,18H5M21,19V5C21,3.89 20.1,3 19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19Z",
			pdf: "M19,3A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5C3.89,21 3,20.1 3,19V5C3,3.89 3.89,3 5,3H19M10.59,10.08C10.57,10.13 10.3,11.84 8.5,14.77C8.5,14.77 5,16.58 5.83,17.94C6.5,19 8.15,17.9 9.56,15.27C9.56,15.27 11.38,14.63 13.79,14.45C13.79,14.45 17.65,16.19 18.17,14.34C18.69,12.5 15.12,12.9 14.5,13.09C14.5,13.09 12.46,11.75 12,9.89C12,9.89 13.13,5.95 11.38,6C9.63,6.05 10.29,9.12 10.59,10.08M11.4,11.13C11.43,11.13 11.87,12.33 13.29,13.58C13.29,13.58 10.96,14.04 9.9,14.5C9.9,14.5 10.9,12.75 11.4,11.13M15.32,13.84C15.9,13.69 17.64,14 17.58,14.32C17.5,14.65 15.32,13.84 15.32,13.84M8.26,15.7C7.73,16.91 6.83,17.68 6.6,17.67C6.37,17.66 7.3,16.07 8.26,15.7M11.4,8.76C11.39,8.71 11.03,6.57 11.4,6.61C11.94,6.67 11.4,8.71 11.4,8.76Z",
			powerpoint: "M9.8,13.4H12.3C13.8,13.4 14.46,13.12 15.1,12.58C15.74,12.03 16,11.25 16,10.23C16,9.26 15.75,8.5 15.1,7.88C14.45,7.29 13.83,7 12.3,7H8V17H9.8V13.4M19,3A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V5C3,3.89 3.9,3 5,3H19M9.8,12V8.4H12.1C12.76,8.4 13.27,8.65 13.6,9C13.93,9.35 14.1,9.72 14.1,10.24C14.1,10.8 13.92,11.19 13.6,11.5C13.28,11.81 12.9,12 12.22,12H9.8Z",
			text: "M14,17H7V15H14M17,13H7V11H17M17,9H7V7H17M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z",
			text_outline: "M5,3C3.89,3 3,3.89 3,5V19C3,20.11 3.89,21 5,21H19C20.11,21 21,20.11 21,19V5C21,3.89 20.11,3 19,3H5M5,5H19V19H5V5M7,7V9H17V7H7M7,11V13H17V11H7M7,15V17H14V15H7Z",
			video: "M19 3H5C3.89 3 3 3.89 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.89 20.1 3 19 3M10 16V8L15 12",
			word: "M15.5,17H14L12,9.5L10,17H8.5L6.1,7H7.8L9.34,14.5L11.3,7H12.7L14.67,14.5L16.2,7H17.9M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z",
			translate: "M12.87,15.07L10.33,12.56L10.36,12.53C12.1,10.59 13.34,8.36 14.07,6H17V4H10V2H8V4H1V6H12.17C11.5,7.92 10.44,9.75 9,11.35C8.07,10.32 7.3,9.19 6.69,8H4.69C5.42,9.63 6.42,11.17 7.67,12.56L2.58,17.58L4,19L9,14L12.11,17.11L12.87,15.07M18.5,10H16.5L12,22H14L15.12,19H19.87L21,22H23L18.5,10M15.88,17L17.5,12.67L19.12,17H15.88Z",
			web: "M16.36,14C16.44,13.34 16.5,12.68 16.5,12C16.5,11.32 16.44,10.66 16.36,10H19.74C19.9,10.64 20,11.31 20,12C20,12.69 19.9,13.36 19.74,14M14.59,19.56C15.19,18.45 15.65,17.25 15.97,16H18.92C17.96,17.65 16.43,18.93 14.59,19.56M14.34,14H9.66C9.56,13.34 9.5,12.68 9.5,12C9.5,11.32 9.56,10.65 9.66,10H14.34C14.43,10.65 14.5,11.32 14.5,12C14.5,12.68 14.43,13.34 14.34,14M12,19.96C11.17,18.76 10.5,17.43 10.09,16H13.91C13.5,17.43 12.83,18.76 12,19.96M8,8H5.08C6.03,6.34 7.57,5.06 9.4,4.44C8.8,5.55 8.35,6.75 8,8M5.08,16H8C8.35,17.25 8.8,18.45 9.4,19.56C7.57,18.93 6.03,17.65 5.08,16M4.26,14C4.1,13.36 4,12.69 4,12C4,11.31 4.1,10.64 4.26,10H7.64C7.56,10.66 7.5,11.32 7.5,12C7.5,12.68 7.56,13.34 7.64,14M12,4.03C12.83,5.23 13.5,6.57 13.91,8H10.09C10.5,6.57 11.17,5.23 12,4.03M18.92,8H15.97C15.65,6.75 15.19,5.55 14.59,4.44C16.43,5.07 17.96,6.34 18.92,8M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z",
			cancel_circle: "M12 2C17.5 2 22 6.5 22 12S17.5 22 12 22 2 17.5 2 12 6.5 2 12 2M12 4C10.1 4 8.4 4.6 7.1 5.7L18.3 16.9C19.3 15.5 20 13.8 20 12C20 7.6 16.4 4 12 4M16.9 18.3L5.7 7.1C4.6 8.4 4 10.1 4 12C4 16.4 7.6 20 12 20C13.9 20 15.6 19.4 16.9 18.3Z",
			printer: "M18,3H6V7H18M19,12A1,1 0 0,1 18,11A1,1 0 0,1 19,10A1,1 0 0,1 20,11A1,1 0 0,1 19,12M16,19H8V14H16M19,8H5A3,3 0 0,0 2,11V17H6V21H18V17H22V11A3,3 0 0,0 19,8Z",
			unzip: "M12 18V16H14V18H12M14 14V12H12V14H14M14 10V8H12V10H14M10 12H12V10H10V12M10 16H12V14H10V16M21 6V20C21 21.1 20.1 22 19 22H5C3.9 22 3 21.1 3 20V6H19M19 6H12V8H10V6L12 6 12 4 8 4 12 0 16 4 12 4 12 6H5V20H19V6Z",
			zip_box_outline: "M12 17V15H14V17H12M14 13V11H12V13H14M14 9V7H12V9H14M10 11H12V9H10V11M10 15H12V13H10V15M21 5V19C21 20.1 20.1 21 19 21H5C3.9 21 3 20.1 3 19V5C3 3.9 3.9 3 5 3H19C20.1 3 21 3.9 21 5M19 5H12V7H10V5H5V19H19V5Z",
			check: "M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z",
			check_all: "M0.41,13.41L6,19L7.41,17.58L1.83,12M22.24,5.58L11.66,16.17L7.5,12L6.07,13.41L11.66,19L23.66,7M18,7L16.59,5.58L10.24,11.93L11.66,13.34L18,7Z",
			cursor_default_outline: "M10.07,14.27C10.57,14.03 11.16,14.25 11.4,14.75L13.7,19.74L15.5,18.89L13.19,13.91C12.95,13.41 13.17,12.81 13.67,12.58L13.95,12.5L16.25,12.05L8,5.12V15.9L9.82,14.43L10.07,14.27M13.64,21.97C13.14,22.21 12.54,22 12.31,21.5L10.13,16.76L7.62,18.78C7.45,18.92 7.24,19 7,19A1,1 0 0,1 6,18V3A1,1 0 0,1 7,2C7.24,2 7.47,2.09 7.64,2.23L7.65,2.22L19.14,11.86C19.57,12.22 19.62,12.85 19.27,13.27C19.12,13.45 18.91,13.57 18.7,13.61L15.54,14.23L17.74,18.96C18,19.46 17.76,20.05 17.26,20.28L13.64,21.97Z"
		};
		Object.keys(map_svg_small = {vimeo: "video", youtube: "video", url: "open_in_new", sort_shuffle_desc: "sort_shuffle_asc"}).forEach((t => e[t] = e[map_svg_small[t]]));
		const t = {
			application: '<path d="M17.875 14.625v2.25h20.25V14.625a2.2511 2.2511 90 00-2.25-2.25H20.125a2.2511 2.2511 90 00-2.25 2.25Zm3.375 1.125a1.1104 1.1104 90 01-1.1171-1.116A1.1261 1.1261 90 0121.25 13.5a1.1396 1.1396 90 011.1318 1.134A1.1228 1.1228 90 0121.25 15.75Zm3.375 0a1.125 1.125 90 111.125-1.125 1.1295 1.1295 90 01-1.125 1.125ZM17.875 18v12.375a2.25 2.25 90 002.25 2.25h15.75a2.25 2.25 90 002.25-2.25V18Zm18 12.375H20.125V20.25h15.75Z"/>',
			archive: '<path d="M28.5,24v-2h2v-2h-2v-2h2v-2h-2v-2h2v-2h-2v-2h2V8h-2V6h-2v2h-2v2h2v2h-2v2h2v2h-2v2h2v2h-2v2h2v2 h-4v5c0,2.757,2.243,5,5,5s5-2.243,5-5v-5H28.5z M30.5,29c0,1.654-1.346,3-3,3s-3-1.346-3-3v-3h6V29z"/><path d="M26.5,30h2c0.552,0,1-0.447,1-1s-0.448-1-1-1h-2c-0.552,0-1,0.447-1,1S25.948,30,26.5,30z"/></g>',
			audio: '<path d="M35.67,14.986c-0.567-0.796-1.3-1.543-2.308-2.351c-3.914-3.131-4.757-6.277-4.862-6.738V5 c0-0.553-0.447-1-1-1s-1,0.447-1,1v1v8.359v9.053h-3.706c-3.882,0-6.294,1.961-6.294,5.117c0,3.466,2.24,5.706,5.706,5.706 c3.471,0,6.294-2.823,6.294-6.294V16.468l0.298,0.243c0.34,0.336,0.861,0.72,1.521,1.205c2.318,1.709,6.2,4.567,5.224,7.793 C35.514,25.807,35.5,25.904,35.5,26c0,0.43,0.278,0.826,0.71,0.957C36.307,26.986,36.404,27,36.5,27c0.43,0,0.826-0.278,0.957-0.71 C39.084,20.915,37.035,16.9,35.67,14.986z M26.5,27.941c0,2.368-1.926,4.294-4.294,4.294c-2.355,0-3.706-1.351-3.706-3.706 c0-2.576,2.335-3.117,4.294-3.117H26.5V27.941z M31.505,16.308c-0.571-0.422-1.065-0.785-1.371-1.081l-1.634-1.34v-3.473 c0.827,1.174,1.987,2.483,3.612,3.783c0.858,0.688,1.472,1.308,1.929,1.95c0.716,1.003,1.431,2.339,1.788,3.978 C34.502,18.515,32.745,17.221,31.505,16.308z"/>',
			cd: '<circle cx="27.5" cy="21" r="12"/><circle style="fill:rgba(255,255,255,.5)" cx="27.5" cy="21" r="3"/><path style="fill:rgba(255,255,255,.3)" d="M25.379,18.879c0.132-0.132,0.276-0.245,0.425-0.347l-2.361-8.813 c-1.615,0.579-3.134,1.503-4.427,2.796c-1.294,1.293-2.217,2.812-2.796,4.427l8.813,2.361 C25.134,19.155,25.247,19.011,25.379,18.879z"/><path style="fill:rgba(255,255,255,.3)" d="M30.071,23.486l2.273,8.483c1.32-0.582,2.56-1.402,3.641-2.484c1.253-1.253,2.16-2.717,2.743-4.275 l-8.188-2.194C30.255,22.939,29.994,23.2,30.071,23.486z"/>',
			code: '<path d="M15.5,24c-0.256,0-0.512-0.098-0.707-0.293c-0.391-0.391-0.391-1.023,0-1.414l6-6 c0.391-0.391,1.023-0.391,1.414,0s0.391,1.023,0,1.414l-6,6C16.012,23.902,15.756,24,15.5,24z"/><path d="M21.5,30c-0.256,0-0.512-0.098-0.707-0.293l-6-6c-0.391-0.391-0.391-1.023,0-1.414 s1.023-0.391,1.414,0l6,6c0.391,0.391,0.391,1.023,0,1.414C22.012,29.902,21.756,30,21.5,30z"/><path d="M33.5,30c-0.256,0-0.512-0.098-0.707-0.293c-0.391-0.391-0.391-1.023,0-1.414l6-6 c0.391-0.391,1.023-0.391,1.414,0s0.391,1.023,0,1.414l-6,6C34.012,29.902,33.756,30,33.5,30z"/><path d="M39.5,24c-0.256,0-0.512-0.098-0.707-0.293l-6-6c-0.391-0.391-0.391-1.023,0-1.414 s1.023-0.391,1.414,0l6,6c0.391,0.391,0.391,1.023,0,1.414C40.012,23.902,39.756,24,39.5,24z"/><path d="M24.5,32c-0.11,0-0.223-0.019-0.333-0.058c-0.521-0.184-0.794-0.755-0.61-1.276l6-17 c0.185-0.521,0.753-0.795,1.276-0.61c0.521,0.184,0.794,0.755,0.61,1.276l-6,17C25.298,31.744,24.912,32,24.5,32z"/>',
			open_in_new: '<path d="m31 15-1.41 1.41L31 17.83 33.17 20H24c-2.76 0-5 2.24-5 5v4h2v-4c0-1.65 1.35-3 3-3h9.17L31 24.17l-1.41 1.41L31 27l6-6-6-6z" />',
			font: '<path d="M33 18H36V30H37V31H33V30H34V27H30L28.5 30H30V31H26V30H27L33 18M34 19L30.5 26H34V19M21 13H26C27.11 13 28 13.89 28 15V26H25V21H22V26H19V15C19 13.89 19.89 13 21 13M22 15V19H25V15H22z"/>',
			excel: '<path d="M23.5,16v-4h-12v4v2v2v2v2v2v2v2v4h10h2h21v-4v-2v-2v-2v-2v-2v-4H23.5z M13.5,14h8v2h-8V14z M13.5,18h8v2h-8V18z M13.5,22h8v2h-8V22z M13.5,26h8v2h-8V26z M21.5,32h-8v-2h8V32z M42.5,32h-19v-2h19V32z M42.5,28h-19v-2h19V28 z M42.5,24h-19v-2h19V24z M23.5,20v-2h19v2H23.5z"/>',
			image: '<circle class="circle-sun" cx="18.931" cy="14.431" r="4.569"/><polygon class="polygon-image" points="6.5,39 17.5,39 49.5,39 49.5,28 39.5,18.5 29,30 23.517,24.517"/>',
			pdf: '<path d="M19.514,33.324L19.514,33.324c-0.348,0-0.682-0.113-0.967-0.326 c-1.041-0.781-1.181-1.65-1.115-2.242c0.182-1.628,2.195-3.332,5.985-5.068c1.504-3.296,2.935-7.357,3.788-10.75 c-0.998-2.172-1.968-4.99-1.261-6.643c0.248-0.579,0.557-1.023,1.134-1.215c0.228-0.076,0.804-0.172,1.016-0.172 c0.504,0,0.947,0.649,1.261,1.049c0.295,0.376,0.964,1.173-0.373,6.802c1.348,2.784,3.258,5.62,5.088,7.562 c1.311-0.237,2.439-0.358,3.358-0.358c1.566,0,2.515,0.365,2.902,1.117c0.32,0.622,0.189,1.349-0.39,2.16 c-0.557,0.779-1.325,1.191-2.22,1.191c-1.216,0-2.632-0.768-4.211-2.285c-2.837,0.593-6.15,1.651-8.828,2.822 c-0.836,1.774-1.637,3.203-2.383,4.251C21.273,32.654,20.389,33.324,19.514,33.324z M22.176,28.198 c-2.137,1.201-3.008,2.188-3.071,2.744c-0.01,0.092-0.037,0.334,0.431,0.692C19.685,31.587,20.555,31.19,22.176,28.198z M35.813,23.756c0.815,0.627,1.014,0.944,1.547,0.944c0.234,0,0.901-0.01,1.21-0.441c0.149-0.209,0.207-0.343,0.23-0.415 c-0.123-0.065-0.286-0.197-1.175-0.197C37.12,23.648,36.485,23.67,35.813,23.756z M28.343,17.174 c-0.715,2.474-1.659,5.145-2.674,7.564c2.09-0.811,4.362-1.519,6.496-2.02C30.815,21.15,29.466,19.192,28.343,17.174z M27.736,8.712c-0.098,0.033-1.33,1.757,0.096,3.216C28.781,9.813,27.779,8.698,27.736,8.712z"/>',
			powerpoint: '<path d="M39.5,30h-24V14h24V30z M17.5,28h20V16h-20V28z"/><path d="M20.499,35c-0.175,0-0.353-0.046-0.514-0.143c-0.474-0.284-0.627-0.898-0.343-1.372l3-5 c0.284-0.474,0.898-0.627,1.372-0.343c0.474,0.284,0.627,0.898,0.343,1.372l-3,5C21.17,34.827,20.839,35,20.499,35z"/><path d="M34.501,35c-0.34,0-0.671-0.173-0.858-0.485l-3-5c-0.284-0.474-0.131-1.088,0.343-1.372 c0.474-0.283,1.088-0.131,1.372,0.343l3,5c0.284,0.474,0.131,1.088-0.343,1.372C34.854,34.954,34.676,35,34.501,35z"/><path d="M27.5,16c-0.552,0-1-0.447-1-1v-3c0-0.553,0.448-1,1-1s1,0.447,1,1v3C28.5,15.553,28.052,16,27.5,16 z"/>',
			text: '<path d="M12.5,13h6c0.553,0,1-0.448,1-1s-0.447-1-1-1h-6c-0.553,0-1,0.448-1,1S11.947,13,12.5,13z"/><path d="M12.5,18h9c0.553,0,1-0.448,1-1s-0.447-1-1-1h-9c-0.553,0-1,0.448-1,1S11.947,18,12.5,18z"/><path d="M25.5,18c0.26,0,0.52-0.11,0.71-0.29c0.18-0.19,0.29-0.45,0.29-0.71c0-0.26-0.11-0.52-0.29-0.71 c-0.38-0.37-1.04-0.37-1.42,0c-0.181,0.19-0.29,0.44-0.29,0.71s0.109,0.52,0.29,0.71C24.979,17.89,25.24,18,25.5,18z"/><path d="M29.5,18h8c0.553,0,1-0.448,1-1s-0.447-1-1-1h-8c-0.553,0-1,0.448-1,1S28.947,18,29.5,18z"/><path d="M11.79,31.29c-0.181,0.19-0.29,0.44-0.29,0.71s0.109,0.52,0.29,0.71 C11.979,32.89,12.229,33,12.5,33c0.27,0,0.52-0.11,0.71-0.29c0.18-0.19,0.29-0.45,0.29-0.71c0-0.26-0.11-0.52-0.29-0.71 C12.84,30.92,12.16,30.92,11.79,31.29z"/><path d="M24.5,31h-8c-0.553,0-1,0.448-1,1s0.447,1,1,1h8c0.553,0,1-0.448,1-1S25.053,31,24.5,31z"/><path d="M41.5,18h2c0.553,0,1-0.448,1-1s-0.447-1-1-1h-2c-0.553,0-1,0.448-1,1S40.947,18,41.5,18z"/><path d="M12.5,23h22c0.553,0,1-0.448,1-1s-0.447-1-1-1h-22c-0.553,0-1,0.448-1,1S11.947,23,12.5,23z"/><path d="M43.5,21h-6c-0.553,0-1,0.448-1,1s0.447,1,1,1h6c0.553,0,1-0.448,1-1S44.053,21,43.5,21z"/><path d="M12.5,28h4c0.553,0,1-0.448,1-1s-0.447-1-1-1h-4c-0.553,0-1,0.448-1,1S11.947,28,12.5,28z"/><path d="M30.5,26h-10c-0.553,0-1,0.448-1,1s0.447,1,1,1h10c0.553,0,1-0.448,1-1S31.053,26,30.5,26z"/><path d="M43.5,26h-9c-0.553,0-1,0.448-1,1s0.447,1,1,1h9c0.553,0,1-0.448,1-1S44.053,26,43.5,26z"/>',
			video: '<path d="M24.5,28c-0.166,0-0.331-0.041-0.481-0.123C23.699,27.701,23.5,27.365,23.5,27V13 c0-0.365,0.199-0.701,0.519-0.877c0.321-0.175,0.71-0.162,1.019,0.033l11,7C36.325,19.34,36.5,19.658,36.5,20 s-0.175,0.66-0.463,0.844l-11,7C24.874,27.947,24.687,28,24.5,28z M25.5,14.821v10.357L33.637,20L25.5,14.821z"/><path d="M28.5,35c-8.271,0-15-6.729-15-15s6.729-15,15-15s15,6.729,15,15S36.771,35,28.5,35z M28.5,7 c-7.168,0-13,5.832-13,13s5.832,13,13,13s13-5.832,13-13S35.668,7,28.5,7z"/>'
		};

		function i(e, t, i) {
			return `<svg viewBox="0 0 48 48" class="svg-folder ${e}"><path class="svg-folder-bg" d="M40 12H22l-4-4H8c-2.2 0-4 1.8-4 4v8h40v-4c0-2.2-1.8-4-4-4z"/><path class="svg-folder-fg" d="M40 12H8c-2.2 0-4 1.8-4 4v20c0 2.2 1.8 4 4 4h32c2.2 0 4-1.8 4-4V16c0-2.2-1.8-4-4-4z"/>${t ? '<path class="svg-folder-symlink" d="M 39.231 23.883 L 28.485 32.862 L 28.485 14.902 Z"/><path class="svg-folder-symlink" d="M 10.065 30.022 L 10.065 40 L 16.205 40 L 16.205 30.022 C 16.205 28.334 17.587 26.953 19.275 26.953 L 32.323 26.953 L 32.323 20.812 L 19.275 20.812 C 14.21 20.812 10.065 24.956 10.065 30.022 Z"/>' : ""}${i ? "" : '<path class="svg-folder-forbidden" d="M 34.441 26.211 C 34.441 31.711 29.941 36.211 24.441 36.211 C 18.941 36.211 14.441 31.711 14.441 26.211 C 14.441 20.711 18.941 16.211 24.441 16.211 C 29.941 16.211 34.441 20.711 34.441 26.211"/><path class="path-exclamation" d="M 22.941 19.211 L 25.941 19.211 L 25.941 28.211 L 22.941 28.211 Z M 22.941 19.211"/><path class="path-exclamation" d="M 22.941 30.211 L 25.941 30.211 L 25.941 33.211 L 22.941 33.211 Z M 22.941 30.211"/>'}</svg>`
		}

		Object.assign(t, {word: t.text, vimeo: t.video, youtube: t.video});
		var a = {
			application: ["app", "exe"],
			archive: ["gz", "zip", "7z", "7zip", "arj", "rar", "gzip", "bz2", "bzip2", "tar", "x-gzip"],
			cd: ["dmg", "iso", "bin", "cd", "cdr", "cue", "disc", "disk", "dsk", "dvd", "dvdr", "hdd", "hdi", "hds", "hfs", "hfv", "ima", "image", "imd", "img", "mdf", "mdx", "nrg", "omg", "toast", "cso", "mds"],
			code: ["php", "x-php", "js", "css", "xml", "json", "html", "htm", "py", "jsx", "scss", "clj", "less", "rb", "sql", "ts", "yml", "webmanifest"],
			excel: ["xls", "xlt", "xlm", "xlsx", "xlsm", "xltx", "xltm", "xlsb", "xla", "xlam", "xll", "xlw", "csv", "numbers"],
			font: ["ttf", "otf", "woff", "woff2", "eot", "ttc"],
			open_in_new: ["url"],
			image: ["wbmp", "tiff", "webp", "psd", "ai", "eps", "jpg", "jpeg", "webp", "png", "gif", "bmp"],
			pdf: ["pdf"],
			powerpoint: ["ppt", "pot", "pps", "pptx", "pptm", "potx", "potm", "ppam", "ppsx", "ppsm", "sldx", "sldm"],
			text: ["epub", "rtf"],
			word: ["doc", "dot", "docx", "docm", "dotx", "dotm", "docb", "odt", "wbk"]
		}, n = {};
		M(Object.keys(a), (function (e) {
			M(a[e], (function (t) {
				n[t] = e
			}))
		})), U.get_type_color = e => "--type-color:var(--type-" + (U.get_icon(e) || "default") + ")";
		const o = U.get_icon = e => e.hasOwnProperty("icon") ? e.icon : e.icon = (() => {
			if (e.mime0 && ["archive", "audio", "image", "video"].includes(e.mime0)) return e.mime0;
			let t = !!e.mime1 && n[e.mime1];
			if (t) return t;
			let i = !!e.ext && n[e.ext];
			return i || "text" === e.mime0 && "text"
		})();
		U.get_svg_icon_custom = (e, t) => '<svg viewBox="0 0 24 24" class="svg-icon svg-' + e + '"><path class="svg-path-' + e + '" d="' + t + '" /></svg>', U.get_svg_icon = function (t) {
			return '<svg viewBox="0 0 24 24" class="svg-icon svg-' + t + '"><path class="svg-path-' + t + '" d="' + e[t] + '" /></svg>'
		}, U.get_svg_icon_class = (t, i) => `<svg viewBox="0 0 24 24" class="${i}"><path class="svg-path-${t}" d="${e[t]}" /></svg>`, U.get_svg_icon_multi = function () {
			for (var t = arguments, i = t.length, a = "", n = 0; n < i; n++) a += '<path class="svg-path-' + t[n] + '" d="' + e[t[n]] + '" />';
			return '<svg viewBox="0 0 24 24" class="svg-icon svg-' + t[0] + '">' + a + "</svg>"
		}, U.get_svg_icon_multi_class = function (t) {
			for (var i = arguments, a = i.length, n = "", o = 1; o < a; o++) n += '<path class="svg-path-' + i[o] + '" d="' + e[i[o]] + '" />';
			return '<svg viewBox="0 0 24 24" class="' + t + '">' + n + "</svg>"
		}, U.get_svg_icon_files_layout = t => {
			if (t.is_dir) return i("icon svg-icon", t.is_link, t.is_readable);
			let a = t.is_pano ? "panorama_variant" : o(t) || "default";
			return `<svg viewBox="0 0 24 24" class="icon svg-icon svg-${a}"><path class="svg-path-${a}" d="${e[a]}" /></svg>`
		}, U.get_svg_icon_files = function (e) {
			return e.is_dir ? i("svg-icon", e.is_link, e.is_readable) : U.get_svg_icon(e.is_pano ? "panorama_variant" : o(e) || "default")
		}, U.get_svg_large = function (e, a) {
			if (e.is_dir) return i("svg-folder-large " + a, e.is_link, e.is_readable);
			let n = o(e), s = e.ext && e.ext.length < 9 ? e.ext : "image" === n && e.mime1;
			return '<svg viewBox="0 0 56 56" class="svg-file svg-' + (n || "default") + (a ? " " + a : "") + '"><path class="svg-file-bg" d="M36.985,0H7.963C7.155,0,6.5,0.655,6.5,1.926V55c0,0.345,0.655,1,1.463,1h40.074 c0.808,0,1.463-0.655,1.463-1V12.978c0-0.696-0.093-0.92-0.257-1.085L37.607,0.257C37.442,0.093,37.218,0,36.985,0z"/>' + (n ? '<g class="svg-file-icon"' + (s ? "" : ' style="transform: translateY(6.5px)"') + ">" + t[n] + "</g>" : "") + '<polygon  class="svg-file-flip" points="37.5,0.151 37.5,12 49.349,12"/>' + (s ? '<path class="svg-file-text-bg" d="M48.037,56H7.963C7.155,56,6.5,55.345,6.5,54.537V39h43v15.537C49.5,55.345,48.845,56,48.037,56z"/><g><text class="svg-file-ext"' + (s.length > 5 ? ' style="font-size:' + (15 - s.length) + 'px"' : "") + ' x="28" y="48.5">' + s + "</text></g>" : "") + (e.is_readable ? "" : '<path class="svg-file-forbidden" d="M 40.691 24.958 C 40.691 31.936 34.982 37.645 28.003 37.645 C 21.026 37.645 15.317 31.936 15.317 24.958 C 15.317 17.98 21.026 12.271 28.003 12.271 C 34.982 12.271 40.691 17.98 40.691 24.958"/><path class="path-exclamation" d="M 26.101 16.077 L 29.907 16.077 L 29.907 27.495 L 26.101 27.495 Z M 26.101 16.077"/><path class="path-exclamation" d="M 26.101 30.033 L 29.907 30.033 L 29.907 33.839 L 26.101 33.839 Z M 26.101 30.033"/>') + "</svg>"
		}
	}();

	class ae {
		static config = t("drag", {enabled: !0, prompt: !1, copy: !0, delete: !1, move: !0});
		static el = {};
		static drop_target_events = {
			dragover: e => e.preventDefault(), dragleave: e => {
				if (e.relatedTarget) {
					if (e.currentTarget.contains(e.relatedTarget)) return
				} else {
					const t = e.currentTarget.getBoundingClientRect();
					if (e.clientY >= t.top && e.clientY < t.bottom && e.clientX >= t.left && e.clientX < t.right) return
				}
				this.toggle_drop_target(e.currentTarget, !1)
			}, drop: e => {
				if (e.preventDefault(), this.toggle_drop_target(e.currentTarget, !1), this.el.drop === this.el.trashcan) return new se(Object.assign(this.fm, {action: "delete", show_prompt: this.config.prompt}));
				if (!this.config.copy && !this.config.move) return;
				const t = this.get_item(this.el.drop);
				if (t && !t.is_writeable) return F.toggle(!1, `${J.get("folder", !0)} ${J.get("is not writeable")}`);
				new se(Object.assign(this.fm, {action: this.get_action(e), dir: this.el.drop.dataset.path, show_prompt: this.config.prompt}))
			}
		};

		static draggable() {
			return this.config.enabled ? ' draggable="true"' : ""
		}

		static get_action(e) {
			return this.config.copy ? this.config.move ? e.altKey || "copy" === e.dataTransfer.effectAllowed ? "copy" : "move" : "copy" : "move"
		}

		static get_item(e) {
			return e.dataset.name ? _c.files[e.dataset.name] : _c.dirs[e.dataset.path]
		}

		static toggle_drop_target(e, t) {
			e && e.isConnected && e.classList.contains("drop-target-active") != !!t && (e.classList.toggle("drop-target-active", t), Object.keys(this.drop_target_events).forEach((i => e[(t ? "add" : "remove") + "EventListener"](i, this.drop_target_events[i]))))
		}

		static valid_drop_target(e) {
			if (e === this.el.trashcan) return this.el.trashcan;
			if (!this.config.copy && !this.config.move) return;
			const t = e.closest("[data-path]");
			if (!t) return;
			const i = this.get_item(t);
			return i && !i.is_dir || this.fm.items.some((e => se.is_in_self(t.dataset.path, e.path))) || this.fm.items.some((e => se.get_parent_path(e.path) === t.dataset.path)) ? void 0 : t
		}

		static dragenter(e) {
			const t = this.valid_drop_target(e.target);
			t && (this.el.drop = t, this.toggle_drop_target(this.el.drop, !0))
		}

		static get_drag_image(e) {
			const t = this.fm.items.length > 1, i = U.get_icon(e), a = !t || (e.is_dir ? this.fm.items.every((e => e.is_dir)) : this.fm.items.every((e => U.get_icon(e) === i))), n = a ? U.get_svg_icon_files(e) : U.get_svg_icon("text"), o = a ? e.is_dir ? "--svg-folder-fg" : `--type-${i || "default"}` : "--type-text", s = document.body;
			s.insertAdjacentHTML("beforeend", `<span class="drag-${t ? "multi" : "single"}" style="--type-color:var(${o})">${t ? `<span class="drag-multi-count">${me.count}</span>` : ""}${n}${t ? "" : e.basename}</span>`);
			const l = s.lastElementChild;
			return q(1).then((() => l.remove())), l
		}

		static dragstart(e) {
			if (!e.target.draggable || !e.target.hasAttribute("draggable") || !e.target.dataset.path) return;
			const t = this.get_item(e.target);
			if (!t) return;
			this.el.drag = e.target, this.el.trashcan && (this.el.trashcan.style.display = "block");
			const i = !!this.el.drag.dataset.name, a = i && !!this.el.drag.dataset.selected && me.count > 1;
			this.fm = i ? {
				list_items: a ? me.selected() : [Q.list.items.find((e => e._values.path === t.path))],
				parent_path: _c.current_path,
				parent_dir: _c.current_dir
			} : {}, this.fm.items = a ? this.fm.list_items.map((e => e._values)) : [t], this.el.drags = a ? this.fm.list_items.map((e => e.elm)) : [this.el.drag], this.el.drags.forEach((e => e.classList.add("drag-el-active"))), e.dataTransfer.setDragImage(this.get_drag_image(t), 0, 0), e.dataTransfer.setData("path", this.el.drag.dataset.path), e.dataTransfer.effectAllowed = this.get_effectAllowed(), document.documentElement.addEventListener("dragenter", this.dragenterhandler), this.el.drag.addEventListener("dragend", (e => this.dragend(e)), {once: !0})
		}

		static get_effectAllowed() {
			return this.config.copy || this.config.move ? this.config.move ? this.config.copy ? "copyMove" : "move" : "copy" : "move"
		}

		static dragend(e) {
			this.el.trashcan && this.el.trashcan.style.removeProperty("display"), this.el.drags.forEach((e => e.classList.remove("drag-el-active"))), this.toggle_drop_target(document.getElementsByClassName("drop-target-active")[0], !1), document.documentElement.removeEventListener("dragenter", this.dragenterhandler)
		}

		static trashcan() {
			document.body.insertAdjacentHTML("beforeend", `<div class="drop-target-trashcan">${U.get_svg_icon_class("delete_outline", "svg-icon")}</div>`), this.el.trashcan = document.body.lastElementChild
		}

		static init() {
			if (!this.config.enabled) return;
			const e = ["copy", "delete", "move"];
			if (e.forEach((e => {
				_c[`allow_${e}`] || (this.config[e] = !1)
			})), e.every((e => !this.config[e]))) return this.config.enabled = !1;
			this.config.delete && this.trashcan(), this.dragenterhandler = this.dragenter.bind(this), document.documentElement.addEventListener("dragstart", (e => this.dragstart(e)))
		}
	}

	ae.init(), (() => {
		const e = {bar: _id("topbar-breadcrumbs")};
		e.bar.insertAdjacentHTML("afterbegin", `<div id="breadcrumbs"></div><div class="breadcrumbs-info" style="display: none"></div><div class="folder-buttons" style="display: none">${function () {
			const e = {contextmenu: "folder_cog_outline", download: !(!_c.allow_mass_download || !Y.download) && "tray_arrow_down", new_file: "file_document_plus_outline", new_folder: "folder_plus_outline", upload: "tray_arrow_up", rename: "rename_outline"};
			return (_c.config && _c.config.folder_buttons ? _c.config.folder_buttons : ["new_file", "new_folder", "upload", "contextmenu"]).map((t => {
				if (!e[t] || !1 === _c[`allow_${t}`]) return "";
				const i = t.replace("_", " ");
				return `<button class="button-icon button-folder-action" data-action="${t}"${"contextmenu" !== t ? ` data-lang="${i}" data-tooltip="${J.get(i)}"` : ""}>${U.get_svg_icon(e[t])}</button>`
			})).join("")
		}()}</div>`), e.breadcrumbs = e.bar.firstElementChild, e.info = e.bar.children[1], e.folder_buttons = e.bar.lastElementChild, e.folder_buttons_writeable_dir = Array.from(e.folder_buttons.children).filter((e => ["rename", "new_file", "new_folder", "upload"].includes(e.dataset.action)));
		let t = [], i = [];

		function o(e, t) {
			return `<span class="crumb"><a href="${p(e)}" data-path="${a(e)}" class="crumb-link"${e ? ae.draggable() : ""}>${t}</a></span>`
		}

		function s(t, i) {
			var a = {targets: t, translateX: i ? [0, -2] : [-2, 0], opacity: i ? [1, 0] : [0, 1], easing: "easeOutQuad", duration: 150, delay: anime.stagger(Math.round(100 / t.length))};
			i && (a.complete = function () {
				var i, a;
				i = t, a = e.breadcrumbs, i.length && M(i, (function (e) {
					(a || e.parentNode).removeChild(e)
				})), l()
			}), anime(a)
		}

		function l() {
			var a = "", l = [], r = "";
			t.length && M(t, (function (e, t) {
				a += a ? "/" + e : e, (l.length || e !== i[t]) && (r += o(a, n(e)), l.push(t + 1))
			})), l.length && (e.breadcrumbs.insertAdjacentHTML("beforeend", r), s(function (e, t) {
				for (var i = [], a = e.length, n = 0; n < a; n++) {
					var o = t(e[n], n);
					o && i.push(o)
				}
				return i
			}(l, (function (t) {
				return e.breadcrumbs.children[t]
			})))), i = t.slice(0)
		}

		e.folder_buttons.children.length && m(e.folder_buttons, ((e, t) => {
			se.actions.includes(e) ? new se({
				action: e,
				items: [_c.current_dir],
				list_items: []
			}) : "download" === e ? ne.zip(_c.current_dir, Q.list.matchingItems.map((e => e._values))) : "upload" === e ? (Q.uppy.setMeta({dir: _c.current_path}), Q.uppy.getPlugin("Dashboard").openModal()) : "contextmenu" === e && U.create_contextmenu(t, "topbar", t.target, _c.current_dir)
		})), U.breadcrumbs_info = function () {
			const t = _c.current_dir, i = se.get_items_type(Object.keys(_c.files).map((e => _c.files[e])));
			e.info.innerHTML = `${_c.files_count} <span data-lang="${i}" class="breadcrumbs-info-type">${J.get(i)}</span>${t.dirsize ? `<span class="breadcrumbs-info-size">${filesize(t.dirsize)}</span>` : ""}`, e.folder_buttons_writeable_dir.forEach((e => {
				"none" === e.style.display != !t.is_writeable && (e.style.display = t.is_writeable ? null : "none")
			})), $(e.info), $(e.folder_buttons)
		}, e.breadcrumbs.innerHTML = o("", U.get_svg_icon("home")), U.set_breadcrumbs = function (a) {
			if ($(e.folder_buttons, !0), $(e.info, !0), t = a.split("/").filter(Boolean), i.length) {
				var n = [];
				M(i, (function (i, a) {
					(n.length || i !== t[a]) && n.unshift(e.breadcrumbs.children[a + 1])
				})), n.length ? s(n, !0) : (e.breadcrumbs.lastElementChild.classList.remove("crumb-active"), l())
			} else l()
		}, C(e.breadcrumbs, (function (e) {
			if ("A" === e.target.nodeName && !w(e, e.target)) return e.target.dataset.path === _c.current_path ? U.create_contextmenu(e, "breadcrumbs", e.target, _c.current_dir) : void U.get_files(e.target.dataset.path, "push")
		}))
	})();
	const ne = (() => {
		const e = (e, t, i) => {
			e.toast.hideToast(), F.toggle(t, i)
		}, i = (t, i, a, n, o) => {
			const s = new JSZip, l = [];
			let c, p = 0, d = 0;
			t.forEach(((m, u) => {
				const h = new XMLHttpRequest;
				h.responseType = "arraybuffer", h.onreadystatechange = o => {
					if (h.readyState === XMLHttpRequest.DONE && (h.status >= 200 && h.status < 400 && h.response && s.file(a && m.path.startsWith(a) ? m.path.slice(a.length + 1) : m.path, h.response, {binary: !0}) && d++, c === m && (c = !1), l[u] = m.filesize, p++, !(p < t.length))) return d ? void s.generateAsync({type: "blob"}).then((t => {
						saveAs(t, i), e(n, !0, `${J.get("download", !0)} ${i}`)
					}), (t => e(n, !1, t.message || "Error saving zip file"))) : e(n, !1, "Failed to download files")
				}, h.onprogress = e => {
					if (l[u] = e.loaded || 0, c || (c = m), c === m) {
						var t = 0;
						l.forEach((e => t += e)), ne.progress(n, t / o)
					}
				}, h.open("GET", r(m, !0), !0), h.send()
			}))
		}, a = (t, a, n, o) => {
			if (!t.length) return e(o, !1, "No files to download!");
			const s = t.reduce(((e, t) => e + t.filesize), 0);
			return ne.config.max_filesize && s >= ne.config.max_filesize ? e(o, !1, `${filesize(s)} exceeds maximum download size ${filesize(ne.config.max_filesize)} `) : ne.config.prompt_filesize && s >= ne.config.prompt_filesize ? ue.confirm.fire({
				title: J.get("download"),
				html: `${J.get("download", !0)} ${a} <strong>${filesize(s)}</strong>?`,
				confirmButtonText: J.get("download"),
				cancelButtonText: J.get("cancel")
			}).then((e => {
				if (!e.isConfirmed) return o.toast.hideToast();
				i(t, a, n, o, s)
			})) : void i(t, a, n, o, s)
		};
		return {
			config: t("download_dir", {javascript: !0, current_dir_only: !1, use_filter: !0, recursive: !0, max_filesize: 2e9, prompt_filesize: 1e8}), progress: (e, t) => {
				e.counter.textContent = Math.round(100 * t) + "%", e.progress_bar.style.setProperty("transform", "scaleX(" + t + ")")
			}, zipname: e => `${e.basename || e.path.split("/").pop() || J.get("download")}.zip`, zip: (t, i) => {
				if (!_c.allow_download) return F.toggle(!1, "Download is not allowed");
				if (!_c.allow_mass_download) return F.toggle(!1, "Mass download is not allowed");
				if (!te) return F.license();
				if (!i.length) return F.toggle(!1, "No files to download!");
				const n = ne.zipname(t), o = F.progress(n), s = i.filter((e => e.is_dir)), l = i.filter((e => !e.is_dir));
				if (!s.length || !ne.config.recursive) return a(l, n, t.path, o);
				fetch(_c.script + "?action=get_downloadables", {method: "POST", headers: {Accept: "application/json", "Content-Type": "application/json; charset=UTF-8"}, body: JSON.stringify({items: s.map((e => ({basename: e.basename, is_dir: !0, path: e.path})))})}).then((e => e.json())).then((i => {
					if (i.error) return e(o, !1, i.error);
					a([...l, ...i], n, t.path, o)
				})).catch((t => e(o, !1, t.message || "Error loading files")))
			}
		}
	})();
	_c.prevent_right_click && (C(document, (e => {
		("IMG" === e.target.nodeName || "VIDEO" === e.target.nodeName || e.target.closest(".menu-li") || e.target.closest(".files-a")) && e.preventDefault()
	}), "contextmenu"), document.documentElement.style.setProperty("--touch-callout", "none")), (() => {
		const e = _c.config.contextmenu || {}, t = Q.contextmenu = {}, i = X.contextmenu = _id("contextmenu"), o = (e, t, i, a, n, o, s) => {
			let l = o ? "a" : "button";
			return a ? `<${l}${o ? ' href="' + ("function" == typeof o ? o(s) : o) + '" target="_blank"' : ""} class="dropdown-item${n ? " " + n : ""}" data-action="${i}">${t ? t.startsWith("M") ? U.get_svg_icon_custom(i, t) : U.get_svg_icon(t) : ""}${J.span(e, !0)}</${l}>` : ""
		};

		function p(e) {
			const t = e.files || (_c.dirs[e.path] || {}).files;
			return t ? Array.isArray(t) && !t.length ? [] : (ne.config.use_filter && _c.current_dir === e ? Q.list.matchingItems.map((e => e._values)) : (i = t, Object.values ? Object.values(i) : Object.keys(i).map((e => i[e])))).filter((e => e.is_readable && (ne.config.recursive || !e.is_dir))) : ne.config.recursive ? [e] : [];
			var i
		}

		function d() {
			t.is_open && u()
		}

		function u(e) {
			if (e != t.is_open) {
				var a = (e ? "add" : "remove") + "EventListener";
				document.documentElement[a]("click", d), document[a]("contextmenu", d), document[a]("visibilitychange", d), window[a]("blur", d), window[a]("scroll", d), Q.popup && Q.popup.topbar && Q.popup.topbar[a]("click", d), X.sidebar_menu && X.sidebar_menu[a]("scroll", d)
			}
			t.item && (t.el.classList.toggle("cm-active", e), t.a && t.a !== t.el && t.a.classList.toggle("cm-active", e)), e != t.is_open && (anime.remove(i), anime({
				targets: i, opacity: e ? [0, 1] : 0, easing: "easeOutQuart", duration: 150, complete: e ? null : function () {
					i.style.cssText = null
				}
			})), t.is_open = !!e
		}

		U.create_contextmenu = (p, d, m, h, f) => {
			if (!_c.context_menu && "topbar" !== d || !m || !h) return;
			if (t.is_open) {
				if (m == t.el) return p.preventDefault();
				t.el && t.el.classList.remove("cm-active"), t.a && t.a !== t.el && t.a.classList.remove("cm-active")
			}
			p.stopPropagation(), t.select_count = "files" === d && p && "contextmenu" === p.type && m.dataset.selected && me.buttons_contextmenu.length && me.count > 1 ? me.count : 0, t.select_count ? i.innerHTML = `<span class="dropdown-header dropdown-header-selected">${U.get_svg_icon("check_all")}<span class="dropdown-header-text">${t.select_count} ${J.get(se.get_items_type(me.selected().map((e => e._values))))}</span></span>${V(me.buttons_contextmenu, (e => o(e, me.actions[e], e, !0)))}` : (h === t.item && m === t.el || (i.innerHTML = `<span class="dropdown-header dropdown-header-basename" title="${a(h.display_name || h.basename)}">${U.get_svg_icon_files(h)}<span class="dropdown-header-text">${n(h.display_name || h.basename)}</span></span>` + o("zoom", "magnify_plus", "popup", "popup" !== d && h.is_popup && h.is_readable) + o("open", "folder_open", "folder", "sidebar" !== d && h.is_dir && h !== _c.current_dir) +
				// o("show info", "info", "modal", !["modal", "popup"].includes(d))
				o("info", "modal", !["modal", "popup"].includes(d))
				+ function (e, t) {
				var i = !!e && c(e);
				return i && "#" !== i ? '<a class="' + t + '" href="' + i + '" target="_blank">' + U.get_svg_icon("url") + J.span("open in new tab") + "</a>" : ""
			}(h, "dropdown-item") + o("copy link", "link", "clipboard", Y.url && Y.clipboard) + function (e, t) {
				return _c.allow_download && Y.download && !e.is_dir && e.is_readable ? `<a href="${r(e, !0)}" class="${t}" download>${U.get_svg_icon("tray_arrow_down")}${J.span("download")}</a>` : ""
			}(h, "dropdown-item") + l.a(h.gps, "dropdown-item", !0) + function (e) {
				if (!_c.allow_download || !_c.allow_mass_download || !e.is_dir || !Y.download || !e.is_readable || !["browser", "zip", "files"].includes(_c.download_dir) || "files" === _c.download_dir && !Y.is_pointer || ne.config.current_dir_only && e !== _c.current_dir) return "";
				if (!e.files) {
					let t = _c.dirs[e.path];
					t && t !== e && t.files && (e = t)
				}
				return Array.isArray(e.files) && !e.files.length ? "" : "files" !== _c.download_dir && ne.config.recursive || e.files && e.files_count ? "zip" !== _c.download_dir || ne.config.javascript ? `<button class="dropdown-item" data-action="download_dir">${U.get_svg_icon("tray_arrow_down")}${J.span("download", !0)}</button>` : `<a href="${s(e)}" class="dropdown-item" data-action="download_dir" download="${te ? a(e.basename) + ".zip" : ""}">${U.get_svg_icon("tray_arrow_down")}${J.span("download", !0)}&nbsp;<span class="no-pointer">Zip</span></a>` : ""
			}(h) + (() => {
				if (["popup", "modal"].includes(d) || !h.is_writeable) return "";
				let e = o("unzip", "unzip", "unzip", "zip" === h.ext && _c.ZipArchive_enabled && _c.allow_unzip) + o("delete", "delete_outline", "delete", _c.allow_delete && h.path) + o("new folder", "folder_plus_outline", "new_folder", _c.allow_new_folder && h.is_dir) + o("new file", "file_document_plus_outline", "new_file", _c.allow_new_file && h.is_dir) + o("rename", "rename_outline", "rename", _c.allow_rename && h.path) + o("move", "folder_move_outline", "move", _c.allow_move && h.path) + o("copy", "content_copy", "copy", _c.allow_copy && h.path) + o("duplicate", "content_duplicate", "duplicate", _c.allow_duplicate && h.path) + o("upload", "tray_arrow_up", "upload", Q.uppy && h.is_dir);
				return e ? '<hr class="dropdown-separator">' + e : ""
			})() + V(Object.keys(e), (t => {
				const i = e[t];
				return o(i.text || t, i.icon, t, !i.condition || i.condition(h), i.class, i.href, h)
			}))), i.style.setProperty("--type-color", `var(--type-${U.get_icon(h) || "default"})`)), i.style.display = "block";
			const _ = m.getBoundingClientRect(), g = (m.clientHeight > 50 ? p.clientY : _.top) - i.clientHeight - 10, v = m.clientHeight > 50 ? p.clientY + 20 : _.bottom + 10, x = v + i.clientHeight <= document.documentElement.clientHeight;
			i.style.top = Math.round(x ? v : Math.max(0, g)) + "px";
			const b = (m.clientWidth > 100 ? p.clientX : _.left + m.offsetWidth / 2) - i.clientWidth / 2, y = Math.max(10, Math.min(document.documentElement.clientWidth - i.clientWidth - 10, b));
			i.style.left = Math.round(y) + "px", i.style.setProperty("--nub-left", Math.round(Math.max(10, Math.min(i.clientWidth - 10, i.clientWidth / 2 - y + b))) + "px"), Object.assign(t, {el: m, item: !t.select_count && h, a: f}), P(i, `dropdown-menu${x ? "" : " nub-bottom"} cm-${d}`), u(!0), i.focus(), p.preventDefault()
		}, m(i, ((i, a) => {
			if (t.select_count) return me.select_action(i);
			if (se.actions.includes(i)) return new se({action: i, items: [t.item]});
			if (e[i]) !e[i].href && e[i].action && e[i].action(t.item); else if ("upload" === i) Q.uppy.setMeta({dir: t.item.path}), Q.uppy.getPlugin("Dashboard").openModal(); else if ("popup" === i) U.open_popup(t.item); else if ("folder" === i) U.close_modal(!1), U.get_files(t.item.path, "push"); else if ("modal" === i) U.open_modal(t.item, !0); else if ("clipboard" === i) F.toggle((n = c(t.item), !!(o = new URL(n, location)) && b(o.href)), J.get("copy link")); else if ("download_dir" === i) {
				if (!_c.allow_mass_download) return F.toggle(!1, "Mass download is not allowed");
				if (te && "zip" === _c.download_dir && !ne.config.javascript) return;
				if (a.preventDefault(), !te) return F.license();
				if ("browser" === _c.download_dir) ne.zip(t.item, p(t.item)); else if ("zip" === _c.download_dir) {
					const e = ne.zipname(t.item), i = F.progress(e);
					new jsFileDownloader({
						url: s(t.item), timeout: 6e5, process: e => {
							e.lengthComputable && ne.progress(i, e.loaded / e.total)
						}, filename: e, forceDesktopMode: !0, nativeFallbackOnError: !0, contentTypeDetermination: "header"
					}).then((() => {
						i.toast.hideToast()
					})).catch((e => {
						E("Download error", e), i.toast.hideToast(), F.toggle(!1, "No files to zip")
					}))
				} else if ("files" === _c.download_dir) {
					const e = p(t.item).filter((e => !e.is_dir));
					if (!e.length) return F.toggle(!1, "No files to download!");
					const i = t => new jsFileDownloader({url: r(e[t], !0)}).then((() => {
						t < e.length - 1 && i(t + 1)
					})).catch((e => F.toggle(!1, "Error downloading files.")));
					i(0)
				}
			}
			var n, o
		}))
	})(), Q.dropdown = {}, (() => {
		const e = [], t = Y.pointer_events ? "pointerdown" : Y.only_touch ? "touchstart" : "mousedown", i = Y.pointer_events ? "pointerup" : "click";
		let a;

		function n(e) {
			e.classList.contains("touch-open") ? a && a.remove() : a = L(document, t, (function (t) {
				t.target.closest(".dropdown") !== e && (a.remove(), e.classList.remove("touch-open"), X.files.style.pointerEvents = "none", q(500).then((() => X.files.style.pointerEvents = null)))
			})), e.classList.toggle("touch-open")
		}

		Y.is_touch && document.addEventListener("touchstart", (function () {
		}), !0);
		const o = e => {
			e.style.display = "block";
			let t = e.getBoundingClientRect(), i = window.innerWidth - (t.x + t.width);
			i < 10 && e.style.setProperty("--offset", i - 10 + "px")
		};
		U.topbar_dropdowns_init = () => e.forEach((e => o(e.lastElementChild))), U.dropdown = function (t, a, s) {
			e.push(t), t.offsetParent && o(t.lastElementChild), Y.only_pointer ? s && C(a, s) : Y.only_touch || !Y.pointer_events ? C(a, (function () {
				n(t)
			}), i) : C(a, (function (e) {
				"mouse" === e.pointerType ? s && s() : n(t)
			}), "pointerup"), Y.is_dual_input ? Y.pointer_events && C(a, (function (e) {
				t.classList.toggle("mouse-hover", "mouse" === e.pointerType)
			}), "pointerover") : Y.is_pointer && t.classList.add("mouse-hover")
		}
	})();
	const oe = (() => {
		const e = t("embed", {enabled: !0, youtube: !0, vimeo: !0, vumbnail: !0, preview: !0, modal: !0, params: "autoplay=1&modestbranding=1"}),
			i = e => `${U.get_svg_icon_class("play", "svg-icon svg-overlay-play svg-overlay-play-embed")}<img class="files-img files-img-placeholder files-lazy" data-src="${e.embed_img}" width="${e.preview_dimensions[0]}" height="${e.preview_dimensions[1]}">`;
		return t => {
			if (!e.enabled) return;
			if (t.embed_img) return i(t);
			if (t.embed) return;
			let a = t.url;
			const n = /(\.|\/)youtu(\.be|be\.com)\//.test(a) ? "youtube" : !!/(\.|\/)vimeo\.com\//.test(a) && "vimeo";
			if (!n) return;
			if (t.icon = n, !e[n]) return;
			const o = a.match("youtube" === n ? /^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/|shorts\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/ : /vimeo.*\/(\d+)/);
			if (!o) return;
			const s = o[1];
			if (s && !(s.length < 6)) {
				if (e.modal) {
					t.embed = `https://${"youtube" === n ? "www.youtube.com/embed/" : "player.vimeo.com/video/"}${s}`;
					let i = (e.params || "").split("&").concat((a.split("?")[1] || "").split("&")).filter(Boolean).join("&");
					i && (t.embed += "?" + i)
				}
				if (e.preview) {
					if ("vimeo" === n && !e.vumbnail) return;
					return t.preview_dimensions = "youtube" === n ? [1280, 720] : [640, 360], t.preview_ratio = t.preview_dimensions[0] / t.preview_dimensions[1], t.embed_img = `https://${"youtube" === n ? `img.youtube.com/vi/${s}/hq720` : `vumbnail.com/${s}`}.jpg`, i(t)
				}
			}
		}
	})();

	class se {
		static actions = ["copy", "delete", "duplicate", "move", "new_file", "new_folder", "rename", "text_edit", "unzip", "zip"];
		static config = t("filemanager", {path_selector_root_value: ".", path_selector_root_label: "", prompt: {delete: !0, duplicate: !0, copy: !0, move: !0, new_file: !0, new_folder: !0, rename: !0, unzip: !0, zip: !0}});

		delete_file(e) {
			this.parent_dir && this.parent_dir.files && (delete this.parent_dir.files[e.basename], "image" === e.mime0 && this.parent_dir.images_count && this.parent_dir.images_count--, this.parent_dir.dirsize && e.filesize && (this.parent_dir.dirsize -= e.filesize))
		}

		check_current_dir() {
			if (!_c.dirs[_c.current_path]) return _c.current_dir && _c.current_dir.path !== _c.current_path ? U.get_files(_c.current_dir.path, "replace") : !1 !== this.parent_path ? U.get_files(this.parent_path, "replace") : void 0
		}

		reload_current_dir(e) {
			e && e === _c.current_dir && U.get_files(_c.current_dir.path, "replace", !0)
		}

		update_dirs(e, t = !1) {
			Object.keys(_c.dirs).forEach((i => {
				if (!(i + "/").startsWith(e + "/")) return;
				const a = _c.dirs[i];
				if (!a) return;
				if (delete _c.dirs[i], !1 === t) return j.remove(re(a.path, a.mtime));
				this.clean_dir(a);
				const n = i.replace(new RegExp("^" + e), t);
				_c.dirs[n] || (_c.dirs[n] = Object.assign(a, {path: n, url_path: this.get_url_path(a.url_path, i, n)}))
			}))
		}

		update_current_dir() {
			if (this.parent_dir_is_current_dir()) {
				if (this.delete_list_items(), _c.file_names = Object.keys(_c.files), _c.files_count = _c.file_names.length, _c.files_count || U.topbar_info(U.get_svg_icon("alert_circle_outline") + J.span("directory is empty"), "warning"), le.disabled(!_c.files_count), U.breadcrumbs_info(), i(), Q.list && Q.list.searched) return le.update_interface();
				me.update()
			}
		}

		delete_list_items() {
			this.list_items.forEach((e => {
				const t = Q.list.items.indexOf(e);
				if (t < 0) return;
				e.elm.parentElement === X.files && e.elm.remove(), Q.list.items.splice(t, 1);
				const i = Q.list.matchingItems.indexOf(e);
				i > -1 && ["matchingItems", "visibleItems"].forEach((e => Q.list[e].splice(i, 1)))
			}))
		}

		get_target_ul(e) {
			if (!e || !X.sidebar_menu) return;
			if (!e.path) return X.sidebar_menu.firstElementChild;
			const t = e.menu_li;
			if (!t) return;
			if ("UL" === t.lastElementChild.nodeName) return t.lastElementChild;
			const i = t.dataset.level || 0;
			if (i >= _c.menu_max_depth) return;
			t.insertAdjacentHTML("beforeend", `<ul style="--depth:${i}" class="menu-ul"></ul>`), t.classList.add("has-ul", "menu-li-open");
			const a = t.firstElementChild;
			return a.firstElementChild.remove(), a.insertAdjacentHTML("afterbegin", U.get_svg_icon_multi_class("button-icon menu-icon menu-icon-toggle", "plus", "minus") + U.get_svg_icon_multi_class("menu-icon menu-icon-folder menu-icon-folder-toggle", "folder", "folder_plus", "folder_minus")), t.lastElementChild
		}

		remove_ul(e) {
			if (!e) return;
			const t = e.parentElement;
			e.remove(), t.classList.remove("has-ul", "menu-li-open", "menu-li-closed");
			const i = t.firstElementChild;
			i.firstElementChild.remove();
			const a = i.firstElementChild;
			for (var n = 0; n < 2; n++) a.lastElementChild.remove();
			a.classList.remove("menu-icon-folder-toggle")
		}

		clear_max_depth_uls(e) {
			if (!e) return;
			const t = e.parentElement, i = 1 * (t.parentElement.dataset.level || 0);
			_class("menu-ul", e).forEach((e => {
				if (!e.isConnected) return;
				let a = i, n = e;
				for (; n !== t;) n = n.parentElement.parentElement, a++;
				a >= _c.menu_max_depth && this.remove_ul(e)
			}))
		}

		li_looper(e, t, i, a) {
			if (!e) return;
			[e].concat(_class("menu-li", e)).forEach((e => {
				const n = e.dataset.path, o = _c.dirs[n];
				if (!o) return;
				const s = e.firstElementChild, l = e.dataset.path = s.dataset.path = n.replace(new RegExp("^" + t), i);
				s.href = p(l);
				const r = (l.match(/\//g) || []).length + 1;
				e.dataset.level != r && (e.dataset.level = r, "UL" === e.lastElementChild.nodeName && (e.lastElementChild.style = "--depth:" + r)), a(e, s, o, n, l)
			}))
		}

		clean_dir(e, t = !0) {
			e && (t && delete e.files, delete e.html, delete e.json_cache, j.remove(re(e.path, e.mtime)))
		}

		get_url_path(e, t, i) {
			return !(!e || !e.endsWith(t)) && e.replace(new RegExp(t + "$"), i)
		}

		file_exists(e, t, i = !1) {
			if (!t) return;
			const a = e.toLowerCase();
			if (t.files && Object.keys(t.files).some((e => e.toLowerCase() === a))) return !0;
			if (!i) return;
			const n = se.create_path(t.path.toLowerCase(), a);
			return Object.keys(_c.dirs).some((e => e.toLowerCase() === n))
		}

		get_unique_filename(e, t, i = !1) {
			if (!this.file_exists(e, t, i)) return e;
			const a = i ? [] : e.split("."), n = a.length > 1 && (a[0] || a[2]) ? "." + a.pop() : "";
			let o = n ? a.join(".") : e, s = 2;
			const l = o.split("-"), r = l.pop();
			for (l.length && /^-?\d+$/.test(r) && (o = l.join("-"), s++); this.file_exists(e, t, i);) e = `${o}-${s}${n}`, s++;
			return e
		}

		static get_items_type(e) {
			if (!e.length) return "files";
			let t = 0, i = 0;
			e.forEach((e => {
				if (e.is_dir) return i++;
				e.image && t++
			}));
			return `${i === e.length ? "folder" : t === e.length ? "image" : "file"}${e.length > 1 ? "s" : ""}`
		}

		prompt_highlight_path(e, t) {
			return `<div class="files-swal2-path">${e || !t ? `<div class="files-swal2-path-path">${e ? n(e) + "/" : U.get_svg_icon("home")}</div>` : ""}${t ? `<div class="files-swal2-path-highlight">${n(t)}</div>` : ""}</div>`
		}

		get_datalist_dirs() {
			return `<datalist id="datalist_dirs">${Object.keys(_c.dirs).sort(((e, t) => e.localeCompare(t, void 0, {numeric: !0, sensitivity: "base"}))).map((e => `<option value="${e ? a(e) : se.config.path_selector_root_value}">${e ? "" : se.config.path_selector_root_label || `🏠 ${J.get("home", !0)}`}</option>`)).join("")}</datalist>`
		}

		select_input_text() {
			if (!this.name_action) return;
			if (!Y.is_pointer) return;
			const e = Swal.getInput();
			if (!e || !e.value || e !== document.activeElement) return;
			if ("new_folder" === this.action) return e.select();
			if (["duplicate", "rename"].includes(this.action) && this.first_item.is_dir) return e.select();
			const t = e.value.lastIndexOf(".");
			return t < 1 ? e.select() : e.setSelectionRange(0, t)
		}

		stri_match(e, t) {
			return e.toUpperCase() === t.toUpperCase()
		}

		is_invalid(e, t) {
			return setTimeout((() => this.select_input_text()), 1), `${U.get_svg_icon("alert_circle_outline")} ${e}${t ? `<span class="files-swal2-invalid-chars">${[...new Set(t)].join("")}</span>` : ""}`
		}

		invalid_name(e, t, i) {
			if (!e) return;
			const a = e.match(/[<>:"'/\\|?*#]|\.\.|\.$/g);
			return a ? this.is_invalid(`${J.get("invalid", !0)} ${J.get("name")}`, a) : this.file_exists(e, _c.dirs[t], i) ? this.is_invalid((i ? "Folder" : "File") + " already exists") : void 0
		}

		invalid_rename(e, t) {
			return !this.stri_match(e, t.basename) && (t.is_dir && !t.is_writeable ? this.is_invalid(`${J.get("folder", !0)} ${J.get("is not writeable")}`) : this.invalid_name(e, this.parent_path, t.is_dir))
		}

		is_invalid_path_name(e) {
			if (!e) return;
			const t = e.match(/^\/|\.(\.|\/)|\/\/|[<>:"'\\|?*#]/g);
			return t ? this.is_invalid(`${J.get("invalid", !0)} ${J.get("folder")} ${J.get("name")}`, t) : void 0
		}

		is_invalid_copy_move_path(e) {
			if (!e) return;
			const t = _c.dirs[e];
			if (t && !t.is_writeable) return this.is_invalid(`${J.get("folder", !0)} ${J.get("is not writeable")}`);
			const i = this.is_invalid_path_name(e);
			return i || (this.parent_path === e || !this.parent_path && e === se.config.path_selector_root_value ? this.is_invalid(`Can't ${this.action} items into existing location`) : this.into_self(e) ? this.is_invalid(`Can't ${this.action} folders into themselves`) : void 0)
		}

		static is_in_self(e, t) {
			return (e + "/").startsWith(t + "/")
		}

		into_self(e) {
			return this.items.some((t => !!t.is_dir && (!t.path || se.is_in_self(se.create_path(e, t.basename), t.path))))
		}

		toggle_loading_el(e, t) {
			e && e.classList.toggle("fm-processing", !!t)
		}

		toggle_loading(e) {
			["delete", "move", "rename"].includes(this.action) && (this.items.forEach((t => this.toggle_loading_el(this.get_menu_li(t), e))), this.list_items.forEach((t => this.toggle_loading_el(t.elm, e)))), e ? this.toast_loader = F.loader(this.action_name) : this.toast_loader.hideToast()
		}

		get_menu_li(e) {
			if (!e.is_dir) return;
			const t = e.menu_li ? e : _c.dirs[e.path];
			return t && t.menu_li && t.menu_li.isConnected ? t.menu_li : void 0
		}

		sort_menu_name(e, t) {
			return e.dataset.path.localeCompare(t.dataset.path, void 0, {numeric: !0, sensitivity: "base"})
		}

		sort_menu_date(e, t) {
			const i = _c.dirs[e.dataset.path], a = _c.dirs[t.dataset.path];
			return !i || !a || i.mtime > a.mtime ? 1 : -1
		}

		sort_menu_level(e) {
			if (!e) return;
			const t = Array.from(e.children);
			t.sort(this["sort_menu_" + (_c.menu_sort.startsWith("name") ? "name" : "date")]), _c.menu_sort.endsWith("desc") && t.reverse(), t.forEach((t => e.appendChild(t)))
		}

		static get_parent_path(e) {
			return !!(e = e.replace(/^\/|\/$/g, "")) && e.substring(0, e.lastIndexOf("/"))
		}

		static create_path() {
			return Array.from(arguments).map((e => e.replace(/^\/|\/$/g, ""))).filter(Boolean).join("/")
		}

		get_parent_dir() {
			return this.list_items.length && this.start_dir ? this.start_dir : !1 !== this.parent_path && _c.dirs[this.parent_path]
		}

		parent_dir_is_current_dir() {
			return this.parent_dir && this.parent_dir === _c.current_dir
		}

		get_list_items() {
			if (!Q.list || !_c.files) return [];
			const e = _c.files[this.first_item.basename];
			return e && e.path === this.first_item.path ? this.items.map((e => Q.list.items.find((t => t._values.path === e.path)))).filter(Boolean) : []
		}

		requires_prompt() {
			return this.hasOwnProperty("show_prompt") ? !!this.show_prompt : !["dir", "name"].some((e => this.hasOwnProperty(e))) && se.config.prompt[this.action]
		}

		open_prompt() {
			const e = {
				title: this.action_name,
				input: this.is_input_action && !this.pasted_from ? "text" : null,
				inputPlaceholder: J.get(this.name_action ? "name" : "folder"),
				html: `${this.items.length > 1 || this.pasted_from ? `${this.action_name} ${this.items.length} ${J.get(se.get_items_type(this.items))}${this.pasted_from ? ` ${J.get("from clipboard")}` : ""}?` : this.prompt_highlight_path(this.parent_path, this.first_item.basename)}${this.dir_action ? this.get_datalist_dirs() : ""}`,
				confirmButtonText: this.action_name,
				cancelButtonText: J.get("cancel"),
				inputAttributes: {maxlength: this.dir_action ? 255 : 127, autocapitalize: "off", autocorrect: "off", autocomplete: "off", spellcheck: "false"},
				didOpen: () => this.select_input_text()
			};
			this.dir && (e.inputValue = this.dir), this.dir_action && (e.inputAttributes.list = "datalist_dirs"), "zip" === this.action && Object.assign(e, {
				inputValue: this.get_unique_filename(this.is_multi ? `${J.get("archive")}.zip` : this.first_item.basename + ("zip" !== this.first_item.ext ? ".zip" : ""), this.parent_dir),
				inputValidator: e => e && !e.match(/.+\.zip$/i) ? this.is_invalid("Zip file must end with ", [".zip"]) : this.invalid_name(e, this.parent_path)
			}), "rename" === this.action && Object.assign(e, {inputValue: this.first_item.basename, inputValidator: e => this.invalid_rename(e, this.first_item)}), "duplicate" === this.action && this.is_input_action && Object.assign(e, {
				inputValue: this.get_unique_filename(this.first_item.basename, this.parent_dir, this.first_item.is_dir),
				inputValidator: e => this.invalid_name(e, this.parent_path, this.first_item.is_dir)
			}), this.new_item_action && Object.assign(e, {
				html: this.prompt_highlight_path(this.first_item.path),
				inputValue: this.get_unique_filename("new_file" === this.action ? J.get("file") + ".txt" : J.get("folder"), _c.dirs[this.first_item.path], "new_folder" === this.action),
				inputValidator: e => this.invalid_name(e, this.first_item.path, "new_folder" === this.action)
			}), ["copy", "move"].includes(this.action) && Object.assign(e, {inputValidator: e => this.is_invalid_copy_move_path(e)}), "unzip" === this.action && Object.assign(e, {inputValue: this.parent_path, inputValidator: e => this.is_invalid_path_name(e)}), ue.default.fire(e).then((e => {
				e.isConfirmed && e.value && ("rename" === this.action && this.stri_match(e.value, this.first_item.basename) || (this.dir_action && (this.dir = e.value === se.config.path_selector_root_value ? "" : e.value), this.name_action && (this.name = e.value), this.load()))
			}))
		}

		constructor(e) {
			return Object.keys(e).forEach((t => this[t] = e[t])), this.start_dir = _c.current_dir, this.first_item = this.items[0], this.is_multi = this.items.length > 1, this.name_action = !(!["new_file", "new_folder", "rename", "zip"].includes(this.action) && ("duplicate" !== this.action || this.is_multi)) && this.action, this.dir_action = !!["copy", "move", "unzip"].includes(this.action) && this.action, this.new_item_action = !!["new_file", "new_folder"].includes(this.action) && this.action, this.is_input_action = this.name_action || this.dir_action, this.first_item.path || this.new_item_action ? (this.list_items || (this.list_items = this.get_list_items()), null == this.parent_path && (this.parent_path = this.list_items.length ? _c.current_dir.path : se.get_parent_path(this.first_item.path)), this.parent_dir || (this.parent_dir = this.get_parent_dir()), this.action_name = J.get((this.action_name || this.action).replace("_", " "), !0), this.requires_prompt() ? this.open_prompt() : void this.load()) : F.toggle(!1, `${this.action} not allowed for root folder`)
		}

		toast_success() {
			if (!this.partial_fail) return F.toggle(!0, `${this.action_name}`);
			const e = `Failed to ${this.action_name} ${this.partial_fail} items`;
			if (X.sidebar_menu && this.items.some((e => e.is_dir && this.get_menu_li(e)))) return F.refresh(e);
			F.toggle(!1, e)
		}

		success() {
			if (this.complete && this.complete(!0), this.parent_dir || (this.parent_dir = this.get_parent_dir()), this.toast_success(), "unzip" === this.action) {
				const e = _c.dirs[this.dir];
				this.clean_dir(e), this.reload_current_dir(e)
			} else if ("text_edit" === this.action) this.clean_dir(this.parent_dir); else if ("rename" === this.action) {
				const e = this.first_item.basename, t = this.name, i = this.first_item.path, a = i.replace(new RegExp(e + "$"), t), n = this.get_menu_li(this.first_item);
				if (n && (this.li_looper(n, i, a, ((e, t, i, a, n) => {
					this.clean_dir(i), _c.dirs[n] = Object.assign(i, {path: n, url_path: this.get_url_path(i.url_path, a, n)}), delete _c.dirs[a]
				})), n.firstElementChild.lastChild.nodeValue = t, this.sort_menu_level(n.parentElement), ve.update()), this.first_item.is_dir && (this.update_dirs(i, a), _c.dirs[a] && (_c.dirs[a].basename = t)), this.clean_dir(this.parent_dir, !1), this.parent_dir && this.parent_dir.files) {
					const n = this.parent_dir.files[e];
					if (n && (this.parent_dir.files[t] = Object.assign(n, {basename: t, path: a, url_path: this.get_url_path(n.url_path, i, a)}), delete this.parent_dir.files[e], this.parent_dir_is_current_dir())) {
						_c.file_names = Object.keys(_c.files);
						const e = this.list_items[0];
						if (e && n === e._values) {
							const i = e.elm;
							i.href = r(n), i.dataset.name = _class("name", i)[0].firstChild.nodeValue = t, i.dataset.path = a, Q.list.searched && le.update(), "name" === Q.sort.sort && U.set_sort()
						}
					}
				}
			} else if ("new_file" === this.action) {
				const e = _c.dirs[this.first_item.path];
				this.clean_dir(e), this.reload_current_dir(e)
			} else if ("new_folder" === this.action) {
				if (!_c.menu_exists && _c.menu_enabled) return location.reload(!0);
				const e = _c.dirs[this.first_item.path], t = this.get_target_ul(e);
				if (t) {
					const i = se.create_path(this.first_item.path, this.name);
					t.insertAdjacentHTML("beforeend", `<li data-level="${1 * (t.parentElement.dataset.level || 0) + 1}" data-path="${a(i)}" class="menu-li"><a href="${p(i)}" class="menu-a" data-path="${a(i)}" draggable="true">${U.get_svg_icon_class("folder", "menu-icon menu-icon-folder")}${n(this.name)}</a></li>`);
					_c.dirs[i] = {basename: this.name, fileperms: e.fileperms, filetype: "dir", is_dir: !0, is_writeable: !!e.is_writeable, is_readable: !!e.is_readable, menu_li: t.lastElementChild, mime: "directory", mtime: Math.round(Date.now() / 1e3), path: i, url_path: !!e.url_path && se.create_path(e.url_path, this.name)};
					this.sort_menu_level(t), ve.update()
				}
				this.clean_dir(e), this.reload_current_dir(e)
			} else if ("copy" === this.action) {
				const e = _c.dirs[this.dir], t = this.items.filter((e => e.is_dir)), i = !!t.length && this.get_target_ul(e);
				i && t.forEach((e => {
					const t = e.path, a = se.create_path(this.dir, e.basename);
					if (_c.dirs[a]) return;
					const n = this.get_menu_li(e);
					if (!n) return;
					const o = i.appendChild(n.cloneNode(!0));
					o && (this.clear_max_depth_uls(o), this.li_looper(o, t, a, ((e, t, i, a, n) => {
						t.classList.remove("menu-active");
						const o = _c.dirs[n] = Object.assign({}, i, {menu_li: e, mtime: Math.round(Date.now() / 1e3), path: n, url_path: this.get_url_path(i.url_path, a, n)});
						this.clean_dir(o)
					})))
				})), this.sort_menu_level(i), i && ve.update(), this.clean_dir(e), this.reload_current_dir(e)
			} else if ("move" === this.action) {
				const e = _c.dirs[this.dir], t = this.items.filter((e => e.is_dir)), i = !!t.length && this.get_target_ul(e);
				i && t.forEach((e => {
					const t = e.path, a = se.create_path(this.dir, e.basename);
					if (_c.dirs[a]) return;
					const n = this.get_menu_li(e);
					if (!n) return;
					const o = n.parentElement, s = i.appendChild(n);
					s && (this.clear_max_depth_uls(s), this.li_looper(s, t, a, ((e, t, i, a, n) => {
						t.classList.remove("menu-active"), delete _c.dirs[a], this.clean_dir(i);
						_c.dirs[n] = Object.assign(i, {mtime: Math.round(Date.now() / 1e3), path: n, url_path: this.get_url_path(i.url_path, a, n)})
					})), o && !o.children.length && this.remove_ul(o))
				})), this.items.forEach((e => {
					e.is_dir && this.update_dirs(e.path, se.create_path(this.dir, e.basename)), this.partial_fail || this.delete_file(e)
				})), this.sort_menu_level(i), i && ve.update(), this.clean_dir(this.parent_dir, this.partial_fail), this.clean_dir(e), this.partial_fail || this.update_current_dir(), this.reload_current_dir(e), this.partial_fail && this.reload_current_dir(this.parent_dir)
			} else if ("zip" === this.action) this.clean_dir(this.parent_dir), this.reload_current_dir(this.parent_dir); else if ("duplicate" === this.action) {
				const e = this.items.filter((e => e.is_dir)), t = !!e.length && this.get_target_ul(this.parent_dir);
				t && e.forEach((e => {
					const i = this.get_menu_li(e);
					if (!i) return;
					const a = t.appendChild(i.cloneNode(!0));
					if (!a) return;
					const n = this.name || this.get_unique_filename(e.basename, this.parent_dir, !0), o = e.path, s = o.replace(new RegExp(e.basename + "$"), n);
					this.li_looper(a, o, s, ((e, t, i, a, n) => {
						t.classList.remove("menu-active");
						const o = _c.dirs[n] = Object.assign({}, i, {menu_li: e, mtime: Math.round(Date.now() / 1e3), path: n, url_path: this.get_url_path(i.url_path, a, n)});
						this.clean_dir(o)
					})), a.firstElementChild.lastChild.nodeValue = n;
					const l = _c.dirs[s];
					l && (l.basename = n)
				})), this.sort_menu_level(t), t && ve.update(), this.clean_dir(this.parent_dir), this.reload_current_dir(this.parent_dir)
			} else if ("delete" === this.action) {
				const e = X.sidebar_menu ? this.items.map((e => !!e.is_dir && this.get_menu_li(e))).filter(Boolean) : [];
				e.forEach((e => {
					const t = e.parentElement;
					if (t.children.length <= 1 && t.classList.contains("menu-ul")) return this.remove_ul(t);
					e.remove()
				})), this.items.forEach((e => {
					e.is_dir && this.update_dirs(e.path), this.partial_fail || this.delete_file(e)
				})), e.length && ve.update(), this.clean_dir(this.parent_dir, this.partial_fail), this.partial_fail || this.update_current_dir(), this.partial_fail && this.reload_current_dir(this.parent_dir)
			}
			this.check_current_dir()
		}

		dir_is_writeable(e) {
			return !e || e.is_writeable
		}

		load() {
			if (_c.hasOwnProperty(`allow_${this.action}`) && !_c[`allow_${this.action}`]) return F.toggle(!1, `${this.action} is not allowed`);
			if (_c.demo_mode) return F.demo();
			if (!te) return F.license();
			if (this.pasted_from && (this.dir = _c.current_dir.path), this.dir && this.into_self(this.dir)) return F.toggle(!1, `Can't ${this.action_name} folders into themselves`);
			if (this.dir_action && !this.dir_is_writeable(_c.dirs[this.dir])) return F.toggle(!1, `${J.get("folder", !0)} ${J.get("is not writeable")}`);
			if (!["copy", "unzip"].includes(this.action) && !this.dir_is_writeable(this.new_item_action ? this.first_item : this.parent_dir)) return F.toggle(!1, `${J.get("folder", !0)} ${J.get("is not writeable")}`);
			this.toggle_loading(!0);
			const e = {items: this.items.map((e => ({basename: e.basename, is_dir: e.is_dir, path: e.path})))};
			["dir", "name", "text"].forEach((t => {
				this.hasOwnProperty(t) && (e[t] = this[t])
			})), fetch(`${_c.script}?action=${this.action}`, {
				method: "POST",
				headers: {Accept: "application/json", "Content-Type": "application/json; charset=UTF-8"},
				body: JSON.stringify(e)
			}).then((e => e.ok ? e.json() : Promise.reject(new Error(e.status && e.statusText ? `${e.status} ${e.statusText}` : "Error")))).then((e => "login" === e.error ? (this.toggle_loading(!1), F.login(), void (this.complete && this.complete(!1))) : e.error || !e.success ? Promise.reject(new Error(e.error || "Error")) : (this.toggle_loading(!1), this.partial_fail = e.fail && ["delete", "move", "duplicate", "copy"].includes(this.action) ? e.fail : 0, void this.success()))).catch(((e, t) => {
				this.toggle_loading(!1), F.toggle(!1, e.message || "Error"), this.complete && this.complete(!1)
			}))
		}
	}

	_c.allow_upload && U.load_plugin("uppy", (() => {
		function e() {
			let e = p.watermark.use_image || !!p.watermark.text;
			p.watermark.enabled = e;
			let t = !e && d;
			if (p.strict === t) return;
			p.strict = t;
			let i = n.getPlugin("Compressor");
			i && i.setOptions(p)
		}

		const i = () => {
			let e = n.getFiles().length;
			[1, 2, 5, 9].forEach((t => l.classList.toggle("uppy-Dashboard-inner-" + t, e >= t))), q(1).then((() => {
				let e = _class("uppy-StatusBar-actionBtn--upload")[0];
				e && (e.className = "button upload-button")
			}))
		}, a = t("uppy", {note: !0, DropTarget: !0, ImageEditor: !0}), n = Q.uppy = new Uppy.Uppy({
			restrictions: {
				maxFileSize: _c.upload_max_filesize || null, allowedFileTypes: _c.upload_allowed_file_types ? _c.upload_allowed_file_types.split(",").map((e => {
					let t = e.trim();
					return t.startsWith(".") || t.includes("/") || t.includes("*") ? t : "." + t
				})).filter((e => e)) : null
			}
		}).use(Uppy.Dashboard, {
			trigger: "#fm-upload",
			thumbnailWidth: Math.round(160 * Math.min(Y.pixel_ratio, 2)),
			showLinkToFileUploadResult: !0,
			showProgressDetails: !0,
			metaFields: [{
				id: "name", name: J.get("name"), placeholder: J.get("name"), render: ({value: e, onChange: t, fieldCSSClasses: i}, a) => a("input", {
					class: i.text, type: "text", value: e, maxlength: 128, onChange: e => t(e.target.value.trim()), onInput: e => {
						e.target.value = e.target.value.replace(/[#%&(){}\\<>*?/$!'":;\[\]@+`|=]/gi, "").replace("..", ".")
					}, "data-uppy-super-focusable": !0
				})
			}],
			doneButtonHandler: () => {
				u(!1), n.cancelAll()
			},
			closeModalOnClickOutside: !0,
			animateOpenClose: !1,
			proudlyDisplayPoweredByUppy: !1,
			showRemoveButtonAfterComplete: _c.allow_delete,
			theme: "dark" === _c.theme ? "dark" : "light"
		}).use(Uppy.XHRUpload, {endpoint: _c.script + "?action=upload", validateStatus: (e, t, i) => B(t, "success"), getResponseError: (e, t) => B(e, "error")}).on("files-added", (e => {
			i()
		})).on("file-removed", (e => {
			i()
		})).on("cancel-all", (e => {
			i()
		})).on("file-removed", ((e, t) => {
			_c.allow_delete && "removed-by-user" === t && e.response && e.response.body && e.response.body.success && e.progress && e.progress.uploadComplete && e.meta && new se({action: "delete", items: [{path: se.create_path(e.meta.dir, e.meta.name), is_dir: !1, basename: e.meta.name}], show_prompt: !1})
		})).on("upload-success", ((e, t) => {
			let i = t.body.filename;
			i && e.name !== i && n.setFileMeta(e.id, {name: i})
		})).on("complete", (e => {
			const t = n.getState().meta.dir, i = [t];
			e.successful && e.successful.length && e.successful.forEach((function (e) {
				if (e.uploadURL && (e.uploadURL = new URL(e.uploadURL, location.href).href), !e.meta.relativePath) return;
				const a = se.get_parent_path(se.create_path(t, e.meta.relativePath));
				a && -1 === i.indexOf(a) && i.push(a)
			})), i.forEach((e => {
				let t = _c.dirs[e];
				t && (["files", "html", "json_cache"].forEach((e => delete t[e])), j.remove(re(e, t.mtime)))
			})), delete Q.contextmenu.el
		})).on("dashboard:modal-open", (() => {
			let t = n.getPlugin("Dashboard"), i = "dark" === _c.theme ? "dark" : "light";
			t.opts.theme !== i && t.setOptions({theme: i}), function () {
				let t = p.watermark;
				if (!t || "object" != typeof t || t.assets_loaded) return;
				t.assets_loaded = !0;
				let i = _c.watermark_files || [], a = (!1 !== t.interface || !t.text) && (t.image_src || i.find((e => /\.(png|jpg|gif|webp)$/i.test(e))));
				a && (t.image = new Image, t.image.addEventListener("load", (() => {
					let i = _id("watermark");
					t.use_image = !i || !1 !== j.get("files:upload:watermark:use_image"), e(), i && (i.insertAdjacentHTML("afterbegin", `<label class="checkbox-label" style="float:right"><input class="checkbox" type="checkbox" id="watermark-image"${t.use_image ? " checked" : ""}>${J.span("use image")}</label>`), _id("watermark-image").addEventListener("change", (i => {
						t.use_image = i.currentTarget.checked, e(), j.set("files:upload:watermark:use_image", t.use_image)
					})))
				})), t.image.src = a);
				let n = (!1 !== t.interface || !a) && (t.font_src || i.find((e => /\.(otf|ttf|woff|woff2)$/i.test(e))));
				if (n) {
					let e = new FontFace("custom_font", `url(${n})`);
					document.fonts.add(e), e.load().then((() => {
						t.font = "10px custom_font"
					}))
				}
			}(), Z(), te || s.classList.add("uppy-nolicense"), a.note && t.setOptions({note: ("string" == typeof a.note ? a.note : "%path% ≤ %upload_max_filesize%").replace("%upload_max_filesize%", _c.upload_max_filesize ? filesize(_c.upload_max_filesize) : "").replace("%path%", n.getState().meta.dir || J.get("home", !0) || se.config.path_selector_root_value)})
		})).on("dashboard:modal-closed", (() => {
			const e = n.getState();
			if (100 === e.totalProgress) {
				if (!e.error || Object.keys(e.files).some((t => !e.files[t].error))) {
					let t = e.meta.dir === _c.current_path;
					t && le.current() && history.replaceState(history.state || null, document.title, location.pathname + location.search), U.get_files(e.meta.dir, t ? "replace" : "push", t)
				}
				n.cancelAll()
			}
		})), o = {ImageEditor: {target: Uppy.Dashboard, quality: .8}, DropTarget: {target: document.body, onDrop: e => u(!0, _c.current_path)}, Webcam: {target: Uppy.Dashboard}};
		Object.keys(o).forEach((e => {
			a[e] && n.use(Uppy[e], "object" == typeof a[e] ? Object.assign(o[e], a[e]) : o[e])
		}));
		const s = document.body.lastElementChild, l = s.firstElementChild.lastElementChild, r = l.firstElementChild, c = l.lastElementChild;
		_c.demo_mode && s.classList.add("uppy-demo-mode"), _c.allow_delete && s.classList.add("uppy-allow-delete"), r.insertAdjacentHTML("afterbegin", U.get_svg_icon("close_thin")), r.className = "button-icon button-uppy-close";
		const p = a.hasOwnProperty("Compressor") && !a.Compressor ? {} : Object.assign({
			interface: !0, enabled: !1, quality: .8, maxWidth: 2e3, maxHeight: 2e3, retainExif: !0, watermark: {}, strict: !0, drew: (e, t) => {
				let i = p.watermark;
				if (!i.enabled) return;
				Object.assign(e, {font: "10px Futura, Gill Sans, Gill Sans MT, Calibri, Trebuchet MS, sans-serif", fillStyle: "white", position: "bottom-right", scale: .3, margin: .05}, i, /(.+)=(.+)/.test(i.text) ? N(i.text) : {});
				let a = e.position.split("-"), n = t.width, o = t.height, [s, l] = ["scale", "margin"].map((t => parseFloat(e[t]) || 0));
				if (!s || isNaN(s) || s <= 0) return console.warn("scale must be a positive number > 0");
				if (isNaN(l) || l < 0) return console.warn("margin must be a positive number >= 0");
				if (l <= 1 && (l *= n), p.watermark.use_image) {
					let t = p.watermark.image, i = t.naturalWidth, r = t.naturalHeight;
					if (!(t && t.complete && i && r)) return;
					let c = s > 1 ? 1 : n / i * s, d = s > 1 ? s : i * c, m = s > 1 ? s * (r / i) : r * c, u = "left" === a[1] ? l : "right" === a[1] ? n - d - l : n / 2 - d / 2, h = "top" === a[0] ? l : "bottom" === a[0] ? o - m - l : o / 2 - m / 2;
					e.drawImage(t, 0, 0, i, r, u, h, d, m)
				} else {
					let t = s > 1 ? s : (e.font.match(/\d+/) || 10) * (n / e.measureText(e.text).width) * s;
					e.font = e.font.replace(/\d+px/, t + "px"), Object.assign(e, {textBaseline: "center" === a[0] ? "middle" : a[0], textAlign: a[1] || "center"});
					let i = "left" === a[1] ? l : "right" === a[1] ? n - l : n / 2, r = "top" === a[0] ? l : "bottom" === a[0] ? o - l : o / 2;
					e.fillText(e.text, i, r)
				}
			}
		}, a.Compressor || {}), d = !!p.strict;
		if (p.interface) {
			let x = {}, b = N(j.get("files:upload:compressor"));

			function m(e) {
				let t = e.currentTarget, i = t.id.replace("compressor-", ""), a = "enabled" === i ? t.checked ? 1 : 0 : t.value.replace(",", ".");
				if (["quality", "maxWidth", "maxHeight"].includes(i)) {
					if (isNaN(a) || "" === a) return t.value = p[i];
					if (a = +a, "quality" === i) (a < 0 || a > 1) && (t.value = a = a > 1 ? 1 : 0); else if (a < 1) t.value = a = 1; else {
						let e = Math.round(a);
						a !== e && (t.value = a = e)
					}
				}
				if (a !== p[i]) {
					if (p[i] = a, j.set("files:upload:compressor", Object.keys(x).map((e => p[e] != x[e] && e + "=" + p[e])).filter(Boolean).join("&"), !0), "enabled" === i) return y.classList.toggle("compressor-enabled", !!a), a ? n.use(Uppy.Compressor, p) : n.removePlugin(n.getPlugin("Compressor"));
					n.getPlugin("Compressor").setOptions(p)
				}
			}

			["enabled", "quality", "maxWidth", "maxHeight"].forEach((e => {
				x[e] = p[e], b[e] && (p[e] = b[e])
			})), p.watermark.text = !1 !== p.watermark.interface && j.get("files:upload:watermark"), c.insertAdjacentHTML("beforeend", `<div class="compressor-container${p.enabled ? " compressor-enabled" : ""}"><label class="checkbox-label"><input class="checkbox" type="checkbox" id="compressor-enabled"${p.enabled ? " checked" : ""}>${J.span("resize and compress images")}</label><div class="compressor-options"><label class="input-label">${J.span("width")}<input type="number" class="input" inputmode="numeric" pattern="[0-9]*" id="compressor-maxWidth" min="0" max="99999" step="10" value="${p.maxWidth}"></label><label class="input-label">${J.span("height")}<input type="number" class="input" inputmode="numeric" pattern="[0-9]*" id="compressor-maxHeight" min="0" max="99999" step="10" value="${p.maxHeight}"></label><label class="input-label">${J.span("quality")}<input${Y.is_pointer ? ' type="number"' : ""} class="input" pattern="[0-9]*" inputmode="decimal" id="compressor-quality" min="0" max="1" step="0.1" value="${p.quality}"></label>${!1 !== p.watermark.interface ? `<div id="watermark"><label class="input-label">${J.span("overlay")}<textarea class="input" rows="1" type="text" id="watermark-text">${p.watermark.text || ""}</textarea>` : ""}</label></div></div></div>`);
			const y = c.lastElementChild;
			_tag("input", y).forEach((e => C(e, m, "change")));
			let w = _id("watermark-text");
			w && (["input", "focus"].forEach((e => C(w, (() => {
				w.style.height = "auto", w.style.height = w.scrollHeight + "px"
			}), e))), C(w, (() => {
				let t = w.value.trim();
				p.watermark.text = t, e(), j.set("files:upload:watermark", t, !0)
			}), "change")), p.enabled && !a.Compressor && "none" === window.getComputedStyle(y).getPropertyValue("display") && (p.enabled = !1, j.remove("files:upload:compressor"))
		}

		function u(e, t) {
			var i = n.getPlugin("Dashboard");
			!!e !== i.isModalOpen() && (i[e ? "openModal" : "closeModal"](), "string" == typeof t && n.setMeta({dir: t}))
		}

		function h(e) {
			U.load_plugin("uppy_locale_" + e, (() => {
				Q.uppy.setOptions({locale: Uppy.locales[e]})
			}), {src: ["@uppy/locales@3.4.0/dist/" + e + ".min.js"]})
		}

		p.enabled && (e(), n.use(Uppy.Compressor, p)), U.uppy_locale = function (e) {
			var t = _(e) || _(_c.lang_default) || "en_US";
			t !== g && (g = t, h(g))
		};
		var f = {no: "nb_NO", nn: "nb_NO"};
		["ar_SA", "bg_BG", "ca_ES", "cs_CZ", "da_DK", "de_DE", "el_GR", "en_US", "es_ES", "es_MX", "fa_IR", "fi_FI", "fr_FR", "gl_ES", "he_IL", "hi_IN", "hr_HR", "hu_HU", "id_ID", "is_IS", "it_IT", "ja_JP", "ko_KR", "nb_NO", "nl_NL", "pl_PL", "pt_BR", "pt_PT", "ro_RO", "ru_RU", "sk_SK", "sr_RS_Cyrillic", "sr_RS_Latin", "sv_SE", "th_TH", "tr_TR", "uk_UA", "uz_UZ", "vi_VN", "zh_CN", "zh_TW"].forEach((function (e) {
			f[e.replace("_", "-").toLowerCase()] = e;
			var t = e.split("_")[0];
			f[t] || (f[t] = e)
		}));
		const _ = e => !!e && f[e];
		let g = _(z("lang", !0)) || _(j.get("files:lang:current")) || !!a.locale && _(a.locale.replace("_", "-").toLowerCase()) || (() => {
			if (_c.lang_auto && Y.nav_langs) for (var e = 0; e < Y.nav_langs.length; e++) {
				const t = Y.nav_langs[e].toLowerCase(), i = _(t);
				if (i) return i;
				const a = !!t.includes("-") && _(t.split("-")[0]);
				if (a) return a
			}
		})() || _(_c.lang_default) || "en_US";
		if ("en_US" !== g && h(g), C(window, (e => {
			n.cancelAll(), u()
		}), "popstate"), z("upload", !0)) var v = setInterval((() => {
			_c.hasOwnProperty("current_path") && (u(!0, _c.current_path), clearTimeout(v))
		}), 300)
	}));
	var le = (() => {
		var e, t = "", i = screen.width >= 768, a = _c.filter_live && Y.is_pointer, n = function () {
			if (!_c.filter_props || "string" != typeof _c.filter_props) return ["basename"];
			var e = ["basename", "filetype", "mime", "features", "title", "headline", "description", "creator", "credit", "copyright", "keywords", "city", "sub-location", "province-state"], t = ["icon"];
			return _c.filter_props.split(",").forEach((function (i) {
				var a = i.trim().toLowerCase();
				"name" === a && (a = "basename"), a && e.includes(a) && !t.includes(a) && t.push(a)
			})), t
		}();

		function o(e) {
			i && (X.filter_container.dataset.input = e || "")
		}

		const s = {
			current: () => t, create: function () {
				Q.list = new ce(X.files.parentElement, {}), M(_c.file_names, ((e, t) => {
					Q.list.items[t]._values = _c.files[e]
				}))
			}, empty: function () {
				Q.list && (Q.list.clear(), Q.list.matchingItems = []), d(X.files), window.scrollY && window.scroll({top: 0})
			}, update_interface: () => {
				const e = Q.list.matchingItems.length;
				P(X.filter_container, t ? "filter-" + (e ? "match" : "nomatch") : ""), U.topbar_info_search(t, e), me.update()
			}, update: () => {
				Q.list.search(t, n), s.update_interface()
			}, filter: function (e) {
				t !== X.filter.value && Q.list && (t = X.filter.value, Q.list.search(t, n), s.update_interface(), !1 !== e && history.replaceState(history.state || null, document.title, t ? "#filter=" + encodeURIComponent(t) : location.pathname + location.search), window.scrollY && window.scrollTo({top: 0}))
			}, hash: function (e) {
				var t = z("filter", !0, !0);
				t && (t = decodeURIComponent(t), X.filter.value = t, o(t), e && s.filter(!1))
			}, clear: function (e) {
				if (t) {
					if (X.filter.value = "", o(), e) return s.filter();
					t = "", P(X.filter_container, "")
				}
			}, disabled: function (e) {
				X.filter.disabled !== !!e && (X.filter.disabled = !!e)
			}
		};
		return (i || a) && C(X.filter, (function (t) {
			o(X.filter.value), a && (e && clearTimeout(e), e = setTimeout(s.filter, S(250, 750, _c.files_count)))
		}), "input"), C(X.filter, s.filter, "change"), s
	})();

	function re(e, t) {
		return "" === e && (e = "ROOT"), "files:dir:" + _c.dirs_hash + ":" + (e || _c.current_dir.path) + ":" + (t || _c.current_dir.mtime)
	}

	!function () {
		var e = !1, t = Y.pixel_ratio >= 1.5 && _c.image_resize_dimensions_retina ? _c.image_resize_dimensions_retina : _c.image_resize_dimensions, s = !!_c.x3_path && _c.x3_path + (_c.x3_path.endsWith("/") ? "" : "/") + "render/w" + (Y.pixel_ratio >= 1.5 ? "480" : "320") + "/";
		image_load_errors = 0, image_resize_min_ratio = Math.max(_c.image_resize_min_ratio, 1), image_resize_types = _c.image_resize_enabled && _c.image_resize_types ? _c.image_resize_types.split(",").map((e => ({
			jpeg: 2,
			jpg: 2,
			png: 3,
			gif: 1,
			webp: 18,
			bmp: 6,
			avif: 19
		}[e.toLowerCase().trim()]))).filter((e => e)) : [], click_window = _c.click_window && !["download", "window"].includes(_c.click) ? _c.click_window.split(",").map((e => e.toLowerCase().trim())).filter((e => e)) : [];
		const r = (e, t) => {
			let i = e.is_pano ? "panorama_variant" : "gif" !== e.browser_image || !e.resize && t ? !!e.gps && "marker" : "gif";
			return i ? U.get_svg_icon_class(i, "svg-icon files-icon-overlay") : ""
		};

		function p(t, i) {
			if (e) return e.abort(), e = !1, void (i && i());
			if (_c.transitions && _c.files_count) if ("list" !== _c.layout) {
				for (var a = X.files.children, n = a.length, o = [], s = window.innerHeight, l = 0; l < n; l++) {
					var r = a[l], c = r.getBoundingClientRect();
					if (!(c.bottom < 0)) if (c.top < s - 10) o.push(r); else if ("columns" !== _c.layout) break
				}
				var p = Math.min(Math.round(200 / o.length), 30);
				d = {targets: o, opacity: t ? [0, 1] : [1, 0], easing: "easeOutQuint", duration: t ? 300 : 150, delay: anime.stagger(p)};
				i && (d.complete = i), anime(d)
			} else {
				anime.remove(X.files);
				var d = {
					targets: X.files, opacity: t ? [0, 1] : [1, 0], easing: "easeOutCubic", duration: t ? 300 : 150, complete: function () {
						t || X.files.style.removeProperty("opacity"), i && i()
					}
				};
				anime(d)
			} else i && i()
		}

		function d(e, t, a, n) {
			i(e, t, n), a && _c.history && history[a + "State"]({path: e}, t, function (e, t) {
				return t === u() ? null : t ? "?" + encodeURI(t).replace(/&/g, "%26").replace(/#/g, "%23") : "//" + location.host + location.pathname
			}(0, e)), document.body.dataset.currentPath = e || "/"
		}

		const u = () => {
			let e = location.search.replace("?", "").split("&")[0];
			return e && !e.includes("=") ? decodeURIComponent(e) : ""
		};

		function g() {
			const e = V(_c.file_names, ((e, i) => {
				var p = _c.files[e];
				if (p.is_dir) {
					let e = _c.dirs[p.path];
					e && p.mtime !== e.mtime && Object.assign(_c.dirs[p.path], p)
				} else if (!p.mime && p.ext && (p.mime = he[p.ext]), p.mime) {
					var d = p.mime.split("/");
					p.mime0 = d[0], d[1] && (p.mime1 = d[1])
				}
				p.display_name = p.url ? p.basename.slice(0, -4) : p.basename, p.image && (p.image.exif && p.image.exif.gps && Array.isArray(p.image.exif.gps) && (p.gps = p.image.exif.gps), p.image.width && p.image.height && (p.dimensions = [p.image.width, p.image.height], p.ratio = p.image.width / p.image.height), p.image.iptc && Object.assign(p, p.image.iptc));
				var m, u = function () {
					if (p.mime1) {
						if ("image" === p.mime0) {
							if (!Y.browser_images.includes(p.mime1)) return;
							if (p.browser_image = p.mime1, p.is_popup = !0, te && p.dimensions && Y.max_texture_size) {
								var e = _c.config.panorama.is_pano(p, Y);
								e && (p.is_pano = e, _c.current_dir.has_pano = !0)
							}
							if (!_c.load_images || !p.is_readable) return;
							var i = !1, a = "files-img files-img-placeholder files-lazy";
							if ("svg+xml" === p.browser_image || "svg" === p.ext) {
								if (p.filesize > _c.config.load_svg_max_filesize) return;
								a += " files-img-svg"
							} else {
								if (function (e) {
									if (_c.image_resize_enabled && e.dimensions && e.mime1 && e.image && _c.resize_image_types.includes(e.mime1)) {
										var i = e.image, a = Math.max(i.width, i.height) / t, n = i.width * i.height;
										if ((!i.type || image_resize_types.includes(i.type)) && !(a < image_resize_min_ratio && e.filesize <= _c.load_images_max_filesize || _c.image_resize_max_pixels && n > _c.image_resize_max_pixels)) {
											if (_c.image_resize_memory_limit) {
												var o = i.width / a, s = i.height / a;
												if ((n * (i.bits ? i.bits / 8 : 1) * (i.channels || 3) * 1.33 + o * s * 4) / 1048576 > _c.image_resize_memory_limit) return
											}
											return !0
										}
									}
								}(p) && (i = p.resize = t), !i && p.filesize > _c.load_images_max_filesize) return;
								"ico" === p.ext && (a += " files-img-ico"), p.dimensions && (p.preview_dimensions = i ? p.ratio > 1 ? [i, Math.round(i / p.ratio)] : [Math.round(i * p.ratio), i] : [p.image.width, p.image.height], p.preview_ratio = p.preview_dimensions[0] / p.preview_dimensions[1])
							}
							return '<img class="' + a + '" data-src="' + function () {
								if (s && p.url_path) {
									var e = p.url_path.match(/\/content\/(.+)/);
									if (e) return s + encodeURI(e.pop())
								}
								if (i && p.image["resize" + i]) return encodeURI(p.image["resize" + i]);
								if (!i && !_c.load_files_proxy_php && p.url_path) return encodeURI(p.url_path).replace(/#/g, "%23");
								let t = p.mtime + "." + p.filesize;
								return `${_c.script}?action=file&file=${encodeURIComponent(p.path)}&${i ? `resize=${i}&${_c.image_cache_hash}.` : ""}${t}`
							}() + '"' + (p.preview_dimensions ? ' width="' + p.preview_dimensions[0] + '" height="' + p.preview_dimensions[1] + '"' : "") + (ae.config.enabled ? ' draggable="false"' : "") + ">"
						}
						if ("video" === p.mime0) {
							if (G("video", p) && (p.is_browser_video = !0, _c.popup_video && (p.is_popup = !0)), _c.video_thumbs_enabled && p.is_readable) return p.preview_dimensions = [480, 320], p.preview_ratio = 1.5, `${p.is_browser_video ? U.get_svg_icon_class("play", "svg-icon svg-overlay-play") : ""}<img class="files-img files-img-placeholder files-lazy" data-src="${_c.script}?action=file&file=${encodeURIComponent(p.path)}&resize=video&${_c.image_cache_hash}.${p.mtime}.${p.filesize}"${p.preview_dimensions ? ` width="${p.preview_dimensions[0]}" height="${p.preview_dimensions[1]}"` : ""}${ae.config.enabled ? ' draggable="false"' : ""}>`
						} else if (p.url) return oe(p)
					}
				}();
				return function (e) {
					var t = "dir" == e.filetype ? "folders" : "files", i = e.image;
					if (i) {
						t += ",image";
						var a = i.width, n = i.height, o = i.exif, s = i.iptc;
						a && n && (t += a === n ? ",square" : a > n ? ",landscape,horizontal" : ",portrait,vertical"), o && (t += ",exif", o.gps && (t += ",gps,maps"), t += V(["Make", "Model", "Software"], (function (e) {
							if (o[e]) return "," + o[e]
						}))), s && (t += ",iptc" + V(["title", "headline", "description", "creator", "credit", "copyright", "keywords", "city", "sub-location", "province-state"], (function (e) {
							if (s[e]) return "," + e
						})))
					}
					e.embed && (t += ",video," + e.icon), e.features = t
				}(p), function (e) {
					let t = !(!e.image || !e.image.exif) && e.image.exif.DateTimeOriginal;
					if (!t || !t.match(/^\d{4}:\d{2}:\d{2}.\d{2}:\d{2}:\d{2}/)) return;
					let i = t.split(/\D/), a = new Date(i[0], i[1] - 1, i[2], i[3], i[4], i[5]);
					isNaN(a) || (e.mtime = Math.floor(a.getTime() / 1e3))
				}(p), `<a href="${c(p, "download" === _c.click)}" target="_blank" class="files-a files-a-${u ? "img" : "svg"}${p.url ? " files-a-url" : ""}" style="${U.get_type_color(p)}${p.preview_ratio ? ";--ratio:" + p.preview_ratio : ""}" data-name="${a(p.basename)}" data-path="${a(p.path)}"${p.is_dir || "download" !== _c.click ? "" : " download"}${ae.draggable()}>${u || U.get_svg_large(p, "files-svg")}\n\t\t\t\t<div class="files-data">\n\t\t\t\t\t${l.span(p.gps, "gps")}\n\t\t\t\t\t<span class="name" title="${a(p.display_name)}">${n(p.display_name)}</span>\n\t\t\t\t\t${p.image && p.image.iptc && p.image.iptc.title ? o((m = p.image.iptc.title, -1 === m.indexOf("<a") ? m : m.replace(/<a\s/g, "<span ").replace(/<\/a>/g, "</span>").replace(/\shref\=/g, " data-href=")), "title") : ""}\n\t\t\t\t\t${U.get_svg_icon_files_layout(p)}\n\t\t\t\t\t${h(p.dimensions, "dimensions")}\n\t\t\t\t\t${f(p, "size")}\n\t\t\t\t\t${v(p.image, "exif", "span")}\n\t\t\t\t\t${o(p.ext ? o(p.ext, "ext-inner") : "", "ext")}\n\t\t\t\t\t${o(U.get_time(p, "L LT", !0, !1), "date")}\n\t\t\t\t\t<span class="flex"></span>\n\t\t\t\t</div>\n\t\t\t\t${r(p, u)}\n\t\t\t\t${_("menu" !== _c.click || p.is_dir, "files-context", !0)}\n\t\t\t\t${R(p)}\n\t\t\t\t${me.config.enabled ? U.get_svg_icon_class("check", "svg-icon svg-check-select") : ""}\n\t\t\t</a>`
			}));
			return _c.config.javascript_cache && (_c.current_dir.html = e), e
		}

		function x(e, t, i) {
			ie(), image_load_errors = 0, _c.current_dir = _c.dirs[e], _c.files = _c.current_dir.files, E(i + " :", e, _c.current_dir), _c.file_names = Object.keys(_c.files), _c.files_count = _c.file_names.length, d(e, _c.current_dir.basename, t), U.breadcrumbs_info(), _c.files_count || U.topbar_info(U.get_svg_icon("alert_circle_outline") + J.span("directory is empty"), "warning"), le.disabled(!_c.files_count), me.reset(_c.files_count), _c.files_count && (X.files.innerHTML = _c.current_dir.html || g(), _c.current_dir.has_pano && U.load_plugin("pannellum"), le.create(), "push" !== t && le.hash(!0), U.set_sort(), !t && _c.current_dir.scroll && _c.current_dir.scroll.y && _c.current_dir.scroll.h == document.body.scrollHeight && window.scrollTo(0, _c.current_dir.scroll.y), "replace" === t && function (e) {
				if (!_c.history || !location.hash) return;
				var t = z("pid", !0, !0), i = t || location.hash.replace("#", "");
				if (!i) return;
				var a = _c.files[decodeURIComponent(i)];
				if (!a) return;
				t && a.is_popup ? U.open_popup(a, !0) : U.open_modal(a);
				return !0
			}() || p(!0))
		}

		function b(e, t) {
			return _c.dirs[e] ? t ? _c.dirs[e].mtime > t.mtime ? _c.dirs[e] = Object.assign(t, _c.dirs[e]) : Object.assign(_c.dirs[e], t) : _c.dirs[e] : _c.dirs[e] = t || {}
		}

		function A(e, t, i) {
			_c.current_dir = !1, me.reset(), U.topbar_info(U.get_svg_icon("alert_circle_outline") + `<strong data-lang="error">${J.get("error")}&nbsp;</strong>${e || ""}`, "error"), d(t, J.get("error") + (e ? ": " + e : "."), i, !0)
		}

		U.get_files = (t, i, a) => {
			if (a || t !== _c.current_path) {
				_c.current_path = t, _c.config.history_scroll && _c.current_dir && (_c.current_dir.scroll = {y: window.scrollY, h: document.body.scrollHeight}), X.topbar_info.className = "info-hidden", le.clear(), a || U.set_breadcrumbs(t), !a && _c.menu_exists && ve.set_active(t);
				var n = _c.dirs[t];
				if (!a && n) {
					if (n.files && _c.config.javascript_cache) return p(!1, (function () {
						le.empty(), x(t, i, "files from JS")
					}));
					if (_c.config.localStorage_cache) {
						var o = j.get_json(re(t, n.mtime));
						if (o) return b(t, o), p(!1, (function () {
							le.empty(), x(t, i, "files from localStorage")
						}))
					}
				}
				le.disabled(!0), _c.menu_exists && ve.loading(!0), X.files_container.classList.add("files-spinner");
				var s = 0, l = !!(n && n.json_cache && _c.config.javascript_cache) && n.json_cache;
				p(!1, (function () {
					le.empty(), r()
				})), e = I({
					params: !l && "dir=" + encodeURIComponent(t), url: l || _c.script + "?action=files", json_response: !0, fail: () => {
						A(t, t, i)
					}, always: () => {
						e = !1, _c.menu_exists && ve.loading(!1), X.files_container.classList.remove("files-spinner")
					}, complete: function (e, a, n) {
						return n ? e.error ? A(e.error, t, i) : (b(t, e), j.set(re(t, e.mtime), a, !1, 1e3), void r()) : A(t, t, i)
					}
				})
			}

			function r(e) {
				1 == s++ && x(t, i, l ? "files from JSON " + l : "files from xmlhttp")
			}
		}, U.init_files = function () {
			if (_c.query_path_invalid) return A("Invalid directory " + _c.start_path, _c.start_path, "replace");
			if (_c.index_html && location.search) {
				let e = location.search.split("&")[0].replace("?", "");
				if (e && e !== _c.start_path && -1 === e.indexOf("=")) {
					_c.start_path = decodeURIComponent(e);
					let t = !(_c.dirs[_c.start_path] || -1 !== e.indexOf("/") || !_c.dirs[""] || !_c.dirs[""].files) && _c.dirs[""].files[_c.start_path];
					t && t.is_dir && b(_c.start_path, t)
				}
			}
			U.get_files(_c.start_path, "replace")
		};
		m(X.topbar_info, (function (e, t) {
			if ("reset" === e) return le.clear(!0)
		})), C(X.files, (e => (e => {
			const t = e.target;
			if (t === X.files) return;
			const i = t.closest(".files-a"), a = !!i && _c.files[i.dataset.name];
			if (a) {
				if (t.classList.contains("context-button")) return U.create_contextmenu(e, "files", t, a, i);
				if (Q.contextmenu.is_open && ("menu" !== _c.click || a.is_dir)) return e.preventDefault();
				if (t.dataset.href) return e.preventDefault(), window.open(t.dataset.href);
				if ("click" === e.type && me.click(e, i)) return e.preventDefault();
				if (!a.is_dir && ("window" === _c.click || a.ext && click_window.includes(a.ext))) return _c.click_window_popup ? _h.popup(e, 1e3, null, i.href, a.basename) : void 0;
				if ((a.is_dir || "download" !== _c.click) && (!a.url || a.embed) && !w(e, i)) return a.embed ? U.open_modal(a, !0) : void (a.is_dir ? (b(a.path, a), U.get_files(a.path, "push")) : "menu" === _c.click ? U.create_contextmenu(e, "files", i, a) : "popup" === _c.click && a.is_popup && a.is_readable ? (Y.is_pointer && y(i, "files-data-hidden", null, 300), U.open_popup(a)) : U.open_modal(a, !0))
			}
		})(e))), history.scrollRestoration = "manual"
	}(), (() => {
		var e = {list: {}, imagelist: {}, blocks: {contain: !0}, grid: {contain: !0, size: {default: 160, min: 80, max: 240}}, rows: {size: {default: 150, min: 80, max: 220}}, columns: {size: {default: 180, min: 120, max: 240}}};
		const t = e => {
			let t = e || p.layout;
			P(X.files, `no-transition-strict list files-${t}${"columns" === t ? ` columns-${n}` : ""}`), q(10).then((() => X.files.classList.remove("no-transition-strict")))
		};
		var i = Object.keys(e);
		let a = z("layout", !0);
		a && i.includes(a) ? _c.layout = a : i.includes(_c.layout) || (_c.layout = "rows");
		let n = j.get("files:layout:columns-type") || "info";
		t(_c.layout);
		var o = getComputedStyle(X.files).getPropertyValue("--img-object-fit").trim() || "cover", s = j.get("files:interface:img-object-fit") || o;

		function l() {
			X.files.style.setProperty("--imagelist-height", r ? "100px" : "100%"), X.files.style[(r ? "set" : "remove") + "Property"]("--imagelist-min-height", "auto")
		}

		s != o && X.files.style.setProperty("--img-object-fit", s);
		var r = j.get("files:layout:imagelist-square");

		function c(t) {
			return {layout: t, ob: e[t], index: i.indexOf(t)}
		}

		null === r && (r = "auto" !== getComputedStyle(X.files).getPropertyValue("--imagelist-height").trim()), l(), ["grid", "rows", "columns"].forEach((function (t) {
			var i, a = e[t].size, n = getComputedStyle(X.files).getPropertyValue("--" + t + "-size");
			n && (a.default = parseInt(n)), a.current = !(i = j.get("files:layout:" + t + "-size")) || isNaN(i) || i == a.default ? a.default : (i = S(a.min, a.max, i), X.files.style.setProperty("--" + t + "-size", i + "px"), i), a.space = function () {
				var e = j.get("files:layout:" + t + "-space-factor");
				return !e || isNaN(e) || 50 == e ? 50 : (e = S(0, 100, e), X.files.style.setProperty("--" + t + "-space-factor", e), 0 == e && X.files.style.setProperty("--" + t + "-border-radius", 0), e)
			}()
		}));
		var p = c(_c.layout);

		function d() {
			var e = p.ob;
			[[v, "imagelist" === p.layout || e.size || e.contain], [x, e.size], [A, e.size], [k, "grid" === p.layout], [cover_toggle, e.contain], [imagelist_square_toggle, "imagelist" === p.layout], [columns_info_toggle, "columns" === p.layout]].forEach((e => {
				!!e[0].style.display == !!e[1] && (e[0].style.display = e[1] ? "" : "none")
			})), e.size && (e.size.min && (y.min = e.size.min), e.size.max && (y.max = e.size.max), e.size.default && (w.value = e.size.default, y.style.setProperty("--range-default-pos", (e.size.default - e.size.min) / (e.size.max - e.size.min))), J.set(b, p.layout), y.value = e.size.current, J.set(L, p.layout), H.value = e.size.space)
		}

		var u = _id("change-layout");
		u.innerHTML = `<button type="button" class="button-icon">${U.get_svg_icon("layout_" + p.layout)}</button><div class="dropdown-menu dropdown-menu-topbar"><span class="dropdown-header" data-lang="layout">${J.get("layout")}</span><div class="dropdown-items">${V(i, (e => `<button class="dropdown-item${e === p.layout ? " active" : ""}" data-action="${e}">${U.get_svg_icon("layout_" + e)}${J.span(e)}</button>`))}</div><div id="layout-options"><div id="layout-sizer"><label for="layout-sizer-range" class="layout-range-label"><span data-lang="size">${J.get("size")}</span><span data-lang="${p.layout}" class="layout-label-type">${J.get(p.layout)}</span></label><input type="range" class="form-range" id="layout-sizer-range" value="200" min="100" max="300" list="layout-size-default"><datalist id="layout-size-default"><option value="200"></datalist></div><div id="layout-spacer"><label for="layout-spacer-range" class="layout-range-label"><span data-lang="space">${J.get("space")}</span><span data-lang="${p.layout}" class="layout-label-type">${J.get(p.layout)}</span></label><input type="range" class="form-range" id="layout-spacer-range" value="50" min="0" max="100" list="layout-space-default"><datalist id="layout-space-default"><option value="50"></datalist></div><div id="layout-aspect"><label for="layout-aspect-range" class="layout-range-label"><span class="layout-aspect-ratio">1:1</span><span data-lang="grid" class="layout-label-type">${J.get("grid")}</span></label><input type="range" class="form-range" id="layout-aspect-range" value="50" min="0" max="100" list="layout-aspect-default"><datalist id="layout-aspect-default"><option value="50"></datalist></div><label class="checkbox-label"><input class="checkbox" type="checkbox" id="covertoggle"${"cover" === s ? " checked" : ""}>${J.span("uniform")}</label><label class="checkbox-label"><input class="checkbox" type="checkbox" id="imagelistsquare"${r ? " checked" : ""}>${J.span("uniform")}</label><label class="checkbox-label"><input class="checkbox" type="checkbox" id="columnsinfo"${"info" === n ? " checked" : ""}>${J.span("details")}</label></div>`;
		var h = u.firstElementChild, f = u.lastElementChild, _ = f.children[1], g = _.children, v = f.children[2], x = v.firstElementChild, b = x.firstElementChild.lastElementChild, y = x.children[1], w = x.children[2].lastElementChild, A = v.children[1], L = A.firstElementChild.lastElementChild, H = A.children[1], k = v.children[2], M = k.children[1];
		cover_toggle = v.children[3], cover_toggle_input = cover_toggle.firstElementChild, imagelist_square_toggle = v.children[4], imagelist_square_toggle_input = imagelist_square_toggle.firstElementChild, columns_info_toggle = v.children[5], columns_info_toggle_input = columns_info_toggle.firstElementChild;
		const E = (e, t, i) => {
			"input" === i.type && _c.files_count > R || "change" === i.type && (j.set("files:layout:" + p.layout + "-" + e, i.currentTarget.value), _c.files_count <= R) || X.files.style.setProperty("--" + p.layout + "-" + e, t)
		}, $ = e => E("size", y.value + "px", e), I = e => e < 50 ? 2 - e / 50 : 1.5 - e / 100, T = e => {
			var t = I(M.value);
			E("aspect", t, e), O(t)
		}, O = e => {
			var t = Math.round(10 * (e > 1 ? e : 1 / e)) / 10;
			k.firstElementChild.firstElementChild.textContent = e > 1 ? t + ":1" : "1:" + t
		}, Z = e => E("space-factor", H.value, e);
		(() => {
			var e = j.get("files:layout:grid-aspect");
			if (e && !isNaN(e) && 50 != e) {
				e = S(0, 100, e), M.value = e;
				var t = I(e);
				X.files.style.setProperty("--grid-aspect", t), O(t)
			}
		})(), d();
		const R = Y.is_pointer ? 200 : 100;

		function D(e) {
			p.layout !== e && (h.innerHTML = U.get_svg_icon("layout_" + e), g[p.index].classList.remove("active"), p = c(e), g[p.index].classList.add("active"), d(), t(), X.sortbar.className = "sortbar-" + e, U.set_config("layout", e))
		}

		C(y, $, "input"), C(y, (e => {
			$(e), p.ob.size.current = y.value
		}), "change"), C(M, T, "input"), C(M, T, "change"), C(H, Z, "input"), C(H, (e => {
			Z(e);
			var t = p.ob.size.space = H.value;
			X.files.style[(t > 0 ? "remove" : "set") + "Property"]("--" + p.layout + "-border-radius", 0)
		}), "change"), C(cover_toggle_input, (e => {
			(s = cover_toggle_input.checked ? "cover" : "contain") == o ? (X.files.style.removeProperty("--img-object-fit"), j.remove("files:interface:img-object-fit")) : (X.files.style.setProperty("--img-object-fit", s), j.set("files:interface:img-object-fit", s))
		}), "change"), C(imagelist_square_toggle_input, (e => {
			r = imagelist_square_toggle_input.checked, l(), j.set("files:layout:imagelist-square", r)
		}), "change"), C(columns_info_toggle_input, (e => {
			n = columns_info_toggle_input.checked ? "info" : "noinfo", j.set("files:layout:columns-type", n), t()
		}), "change"), m(_, D), U.dropdown(u, h, (() => {
			D(i[p.index >= i.length - 1 ? 0 : p.index + 1])
		}))
	})();
	const ce = (pe = {
		448: function (e) {
			e.exports = function (e) {
				return e.handlers.filterStart = e.handlers.filterStart || [], e.handlers.filterComplete = e.handlers.filterComplete || [], function (t) {
					if (e.trigger("filterStart"), e.i = 1, e.reset.filter(), void 0 === t) e.filtered = !1; else {
						e.filtered = !0;
						for (var i = e.items, a = 0, n = i.length; a < n; a++) {
							var o = i[a];
							t(o) ? o.filtered = !0 : o.filtered = !1
						}
					}
					return e.update(), e.trigger("filterComplete"), e.visibleItems
				}
			}
		}, 352: function (e, t, i) {
			var a = i(95), n = i(117);
			e.exports = function (e, t, o) {
				var s = this, l = i(423)(s), r = {
					start: function () {
						s.listClass = "list", s.searchClass = "search", s.sortClass = "sort", s.page = 1e4, s.i = 1, s.items = [], s.visibleItems = [], s.matchingItems = [], s.searched = !1, s.filtered = !1, s.searchColumns = void 0, s.searchDelay = 0, s.handlers = {updated: []}, s.valueNames = [], s.utils = {
							events: a,
							toArray: n
						}, Object.assign(s, t), s.listContainer = "string" == typeof e ? document.getElementById(e) : e, s.listContainer && (s.list = s.listContainer.firstElementChild, s.parse = i(805)(s), s.templater = i(561)(s), s.search = i(821)(s), s.filter = i(448)(s), s.sort = i(745)(s), this.handlers(), this.items(), s.update())
					}, handlers: function () {
						for (var e in s.handlers) s[e] && s.handlers.hasOwnProperty(e) && s.on(e, s[e])
					}, items: function () {
						s.parse(s.list), void 0 !== o && s.add(o)
					}
				};
				this.reIndex = function () {
					s.items = [], s.visibleItems = [], s.matchingItems = [], s.searched = !1, s.filtered = !1, s.parse(s.list)
				}, this.add = function (e, t) {
					if (0 !== e.length && !t) {
						var i = [], a = !1;
						void 0 === e[0] && (e = [e]);
						for (var n = 0, o = e.length; n < o; n++) {
							var r;
							a = s.items.length > s.page, r = new l(e[n], void 0, a), s.items.push(r), i.push(r)
						}
						return s.update(), i
					}
				}, this.show = function (e, t) {
					return this.i = e, this.page = t, s.update(), s
				}, this.remove = function (e, t, i) {
					for (var a = 0, n = 0, o = s.items.length; n < o; n++) s.items[n].values()[e] == t && (s.templater.remove(s.items[n], i), s.items.splice(n, 1), o--, n--, a++);
					return s.update(), a
				}, this.get = function (e, t) {
					for (var i = [], a = 0, n = s.items.length; a < n; a++) {
						var o = s.items[a];
						o.values()[e] == t && i.push(o)
					}
					return i
				}, this.size = function () {
					return s.items.length
				}, this.clear = function () {
					return s.templater.clear(), s.items = [], s
				}, this.on = function (e, t) {
					return s.handlers[e].push(t), s
				}, this.off = function (e, t) {
					var i = s.handlers[e], a = i.indexOf(t);
					return a > -1 && i.splice(a, 1), s
				}, this.trigger = function (e) {
					for (var t = s.handlers[e].length; t--;) s.handlers[e][t](s);
					return s
				}, this.reset = {
					filter: function () {
						for (var e = s.items, t = e.length; t--;) e[t].filtered = !1;
						return s
					}, search: function () {
						for (var e = s.items, t = e.length; t--;) e[t].found = !1;
						return s
					}
				}, this.update = function () {
					var e = s.items, t = e.length;
					s.visibleItems = [], s.matchingItems = [], s.templater.clear();
					for (var i = 0; i < t; i++) e[i].matching() && s.matchingItems.length + 1 >= s.i && s.visibleItems.length < s.page ? (e[i].show(), s.visibleItems.push(e[i]), s.matchingItems.push(e[i])) : e[i].matching() ? (s.matchingItems.push(e[i]), e[i].hide()) : e[i].hide();
					return s.trigger("updated"), s
				}, r.start()
			}
		}, 423: function (e) {
			e.exports = function (e) {
				return function (t, i, a) {
					var n = this;
					this._values = {}, this.found = !1, this.filtered = !1, this.values = function (t, i) {
						if (void 0 === t) return n._values;
						for (var a in t) n._values[a] = t[a];
						!0 !== i && e.templater.set(n, n.values())
					}, this.show = function () {
						e.templater.show(n)
					}, this.hide = function () {
						e.templater.hide(n)
					}, this.matching = function () {
						return e.filtered && e.searched && n.found && n.filtered || e.filtered && !e.searched && n.filtered || !e.filtered && e.searched && n.found || !e.filtered && !e.searched
					}, this.visible = function () {
						return !(!n.elm || n.elm.parentNode != e.list)
					}, function (t, i, a) {
						if (void 0 === i) a ? n.values(t, a) : n.values(t); else {
							n.elm = i;
							var o = e.templater.get(n, t);
							n.values(o)
						}
					}(t, i, a)
				}
			}
		}, 805: function (e, t, i) {
			e.exports = function (e) {
				var t = i(423)(e);
				return e.handlers.parseComplete = e.handlers.parseComplete || [], function () {
					!function (i, a) {
						for (var n = 0, o = i.length; n < o; n++) e.items.push(new t(a, i[n]))
					}(e.list.children, e.valueNames)
				}
			}
		}, 821: function (e) {
			e.exports = function (e) {
				var t, i, a, n = {
					resetList: function () {
						e.i = 1, e.templater.clear(), a = void 0
					}, setOptions: function (e) {
						2 == e.length && e[1] instanceof Array ? t = e[1] : 2 == e.length && "function" == typeof e[1] ? (t = void 0, a = e[1]) : 3 == e.length ? (t = e[1], a = e[2]) : t = void 0
					}, setColumns: function () {
						0 !== e.items.length && void 0 === t && (t = void 0 === e.searchColumns ? n.toArray(e.items[0].values()) : e.searchColumns)
					}, setSearchString: function (e) {
						i = e.toString()
					}, toArray: function (e) {
						var t = [];
						for (var i in e) t.push(i);
						return t
					}
				}, o = {
					list: function () {
						for (var a, n = [], o = i; null !== (a = o.match(/"([^"]+)"/));) n.push(a[1]), o = o.substring(0, a.index) + o.substring(a.index + a[0].length);
						(o = o.trim()).length && (n = n.concat(o.split(/\s+/)));
						for (var s = 0, l = e.items.length; s < l; s++) {
							var r = e.items[s];
							if (r.found = !1, n.length) {
								for (var c = 0, p = n.length; c < p; c++) {
									for (var d = !1, m = 0, u = t.length; m < u; m++) {
										var h = r.values(), f = t[m];
										if (h.hasOwnProperty(f) && void 0 !== h[f] && null !== h[f] && -1 !== ("string" != typeof h[f] ? h[f].toString() : h[f]).toLowerCase().indexOf(n[c])) {
											d = !0;
											break
										}
									}
									if (!d) break
								}
								r.found = d
							}
						}
					}, reset: function () {
						e.reset.search(), e.searched = !1
					}
				};
				return e.handlers.searchStart = e.handlers.searchStart || [], e.handlers.searchComplete = e.handlers.searchComplete || [], function (s) {
					return e.trigger("searchStart"), n.resetList(), n.setSearchString(s), n.setOptions(arguments), n.setColumns(), "" === i ? o.reset() : (e.searched = !0, a ? a(i, t) : o.list()), e.update(), e.trigger("searchComplete"), e.visibleItems
				}
			}
		}, 745: function (e) {
			e.exports = function (e) {
				return e.handlers.sortStart = e.handlers.sortStart || [], e.handlers.sortComplete = e.handlers.sortComplete || [], function () {
					e.trigger("sortStart");
					var t = {};
					(t = arguments[1] || t).valueName = arguments[0], t.order = t.order || "asc", t.insensitive = void 0 === t.insensitive || t.insensitive;
					let i = "desc" === t.order ? -1 : 1;
					e.items.sort((function (e, a) {
						return t.sortFunction(e, a, t) * i
					})), e.update(), e.trigger("sortComplete")
				}
			}
		}, 561: function (e) {
			var t = function (e) {
				var t, i = this, a = function (e, t) {
					var i = e.cloneNode(!0);
					i.removeAttribute("id");
					for (var a = 0, n = t.length; a < n; a++) {
						var o = void 0, s = t[a];
						if (s.data) for (var l = 0, r = s.data.length; l < r; l++) i.setAttribute("data-" + s.data[l], ""); else s.attr && s.name ? (o = i.getElementsByClassName(s.name)[0]) && o.setAttribute(s.attr, "") : (o = i.getElementsByClassName(s)[0]) && (o.innerHTML = "")
					}
					return i
				}, n = function () {
					for (var t = e.list.childNodes, i = 0, a = t.length; i < a; i++) if (void 0 === t[i].data) return t[i].cloneNode(!0)
				}, o = function (e) {
					if ("string" == typeof e) {
						if (/<tr[\s>]/g.exec(e)) {
							var t = document.createElement("tbody");
							return t.innerHTML = e, t.firstElementChild
						}
						if (-1 !== e.indexOf("<")) {
							var i = document.createElement("div");
							return i.innerHTML = e, i.firstElementChild
						}
					}
				}, s = function (t, i, a) {
					var n = void 0, o = function (t) {
						for (var i = 0, a = e.valueNames.length; i < a; i++) {
							var n = e.valueNames[i];
							if (n.data) {
								for (var o = n.data, s = 0, l = o.length; s < l; s++) if (o[s] === t) return {data: t}
							} else {
								if (n.attr && n.name && n.name == t) return n;
								if (n === t) return t
							}
						}
					}(i);
					o && (o.data ? t.elm.setAttribute("data-" + o.data, a) : o.attr && o.name ? (n = t.elm.getElementsByClassName(o.name)[0]) && n.setAttribute(o.attr, a) : (n = t.elm.getElementsByClassName(o)[0]) && (n.innerHTML = a))
				};
				this.get = function (e, t) {
					i.create(e);
					for (var a = {}, n = 0, o = t.length; n < o; n++) {
						var s = void 0, l = t[n];
						if (l.data) for (var r = 0, c = l.data.length; r < c; r++) a[l.data[r]] = e.elm.dataset[l.data[r]]; else l.attr && l.name ? (s = e.elm.getElementsByClassName(l.name)[0], a[l.name] = s ? s.getAttribute(l.attr) : "") : (s = e.elm.getElementsByClassName(l)[0], a[l] = s ? s.innerHTML : "")
					}
					return a
				}, this.set = function (e, t) {
					if (!i.create(e)) for (var a in t) t.hasOwnProperty(a) && s(e, a, t[a])
				}, this.create = function (e) {
					return void 0 === e.elm && (e.elm = t(e.values()), i.set(e, e.values()), !0)
				}, this.remove = function (t) {
					t.elm.parentNode === e.list && e.list.removeChild(t.elm)
				}, this.show = function (t) {
					i.create(t), e.list.appendChild(t.elm)
				}, this.hide = function (t) {
					void 0 !== t.elm && t.elm.parentNode === e.list && e.list.removeChild(t.elm)
				}, this.clear = function () {
					for (; e.list.firstElementChild;) e.list.firstElementChild.remove()
				}, function () {
					var i;
					if ("function" != typeof e.item) {
						if (!(i = "string" == typeof e.item ? -1 === e.item.indexOf("<") ? document.getElementById(e.item) : o(e.item) : n())) throw new Error("The list needs to have at least one item on init otherwise you'll have to add a template.");
						i = a(i, e.valueNames), t = function () {
							return i.cloneNode(!0)
						}
					} else t = function (t) {
						var i = e.item(t);
						return o(i)
					}
				}()
			};
			e.exports = function (e) {
				return new t(e)
			}
		}, 95: function (e, t, i) {
			var a = window.addEventListener ? "addEventListener" : "attachEvent", n = window.removeEventListener ? "removeEventListener" : "detachEvent", o = "addEventListener" !== a ? "on" : "", s = i(117);
			t.bind = function (e, t, i, n) {
				for (var l = 0, r = (e = s(e)).length; l < r; l++) e[l][a](o + t, i, n || !1)
			}, t.unbind = function (e, t, i, a) {
				for (var l = 0, r = (e = s(e)).length; l < r; l++) e[l][n](o + t, i, a || !1)
			}, t.debounce = function (e, t, i) {
				return e
			}
		}, 117: function (e) {
			e.exports = function (e) {
				if (void 0 === e) return [];
				if (null === e) return [null];
				if (e === window) return [window];
				if ("string" == typeof e) return [e];
				if (Array.isArray(e)) return e;
				if ("number" != typeof e.length) return [e];
				if ("function" == typeof e && e instanceof Function) return [e];
				for (var t = [], i = 0, a = e.length; i < a; i++) (Object.prototype.hasOwnProperty.call(e, i) || i in e) && t.push(e[i]);
				return t.length ? t : []
			}
		}
	}, de = {}, function e(t) {
		if (de[t]) return de[t].exports;
		var i = de[t] = {exports: {}};
		return pe[t](i, i.exports, e), i.exports
	}(352));
	var pe, de;
	(() => {
		const e = Q.popup = {
			transitions: {
				glide: e => ({translateX: [10 * e, 0], opacity: [.1, 1], duration: 500, easing: "easeOutQuart"}),
				fade: e => ({opacity: [.1, 1], duration: 400, easing: "easeOutCubic"}),
				zoom: e => ({scale: [1.05, 1], opacity: [.1, 1], duration: 500, easing: "easeOutQuint"}),
				pop: e => ({scale: {value: [.9, 1], duration: 600, easing: "easeOutElastic"}, opacity: {value: [0, 1], duration: 400, easing: "easeOutCubic"}, duration: 600}),
				elastic: e => ({translateX: {value: [50 * e, 0], duration: 600, easing: "easeOutElastic"}, opacity: {value: [.1, 1], duration: 500, easing: "easeOutQuart"}, duration: 600}),
				wipe: e => ({translateX: [10 * e, 0], opacity: [.1, 1], clipPath: [e > 0 ? "inset(0% 25% 0% 65%)" : "inset(0% 65% 0% 25%)", "inset(0% 0% 0% 0%)"], scale: [1.05, 1], duration: 500, easing: "easeOutQuint"})
			}, playing: !1, timer: !1
		};
		let t, i, a, o = j.get("files:popup:locked_caption"), s = screen.width < 375 ? "ll" : screen.width < 414 ? "lll" : "llll", l = screen.width >= 576;
		const c = {
			caption_hide: !0, caption_style: "gradient", caption_align: "center-left", click: "prev_next", downloadEl: !Y.is_pointer, mapEl: !1, play_interval: 5e3,//!_c.hasOwnProperty('popup_interval') || isNaN(_c.popup_interval) ? 5000 : Math.max(_c.popup_interval, 1000),
			history: _c.history, video_autoplay: !0, getDoubleTapZoom: () => (e.toggle_play(!1), 1), getThumbBoundsFn: (e, i) => {
				var a = t.items[e];
				if (img = Q.modal.open ? Q.modal.item === a.item && _class("modal-image", Q.modal.el.preview)[0] : a.img_el, !(a.w && a.h && a.msrc && img && img.offsetParent)) return !!i && p(!0);
				var n = img.getBoundingClientRect();
				if (i) {
					if (n.bottom < 0 || n.top > window.innerHeight) return p(!0);
					p(!1)
				}
				var o = a.w / a.h, s = n.width / n.height, l = getComputedStyle(img), r = "cover" === l.objectFit ? o < s : o > s, c = r ? (img.clientWidth / o - img.clientHeight) / 2 : 0, d = r ? 0 : (img.clientHeight * o - img.clientWidth) / 2, m = img.offsetWidth - img.clientWidth, u = parseFloat(l.padding || l.paddingTop || 0);
				return {x: n.left - d + m / 2 + u, y: n.top - c + window.pageYOffset + m / 2 + u, w: n.width + 2 * d - m - 2 * u, h: n.height + 2 * c - m - 2 * u, img: img}
			}, index: 0, addCaptionHTMLFn: (t, a) => {
				var o = t.item;
				return "topbar" === c.caption_style ? (e.search.innerText = o.basename, !1) : "video" === t.type ? (X.filter.value || (e.search.innerText = o.basename), d(e.caption_center)) : (X.filter.value || d(e.search), o.hasOwnProperty("popup_caption") || (o.popup_caption = '<div class="popup-basename">' + n(o.basename) + '</div><div class="popup-image-meta">' + h(o.dimensions, "popup-dimensions") + f(o, "popup-filesize") + '<span class="popup-date">' + U.get_time(o, s, "LLLL", l) + "</span></div>" + v(o.image, "popup-exif") + g(o.image, "popup")), o.popup_caption ? (e.caption_transition_delay && (e.caption.style.cssText = "transition: none; opacity: 0", i && clearTimeout(i), i = setTimeout((() => {
					e.caption.style.cssText = "transition: opacity 333ms cubic-bezier(0.33, 1, 0.68, 1)", i = setTimeout((() => {
						e.caption.removeAttribute("style")
					}), 333)
				}), e.caption_transition_delay)), e.caption_center.innerHTML = o.popup_caption, !0) : _e.resetEl(e.caption_center))
			}
		};

		function p(i) {
			i !== t.options.showHideOpacity && (t.options.showHideOpacity = i, _e.toggle_class(e.pswp, "pswp--animate_opacity", i))
		}

		function m() {
			var t = e.current_video;
			t && t.pause()
		}

		function u() {
			return !t.options.loop && t.getCurrentIndex() === t.options.getNumItemsFn() - 1
		}

		function b() {
			e.pano_viewer && (e.pano_viewer.destroy(), e.pano_viewer = !1)
		}

		_c.config && _c.config.popup && (Object.assign(c, _c.config.popup), c.play_transition || (c.play_transition = c.transition || "glide"), c.transitions && Object.assign(e.transitions, c.transitions)), U.open_popup = (i, o) => {
			if (i && Q.list.items.length && !e.is_open) {
				var s = {index: 0};
				if (a === Q.list.matchingItems) {
					for (var l = 0; l < e.slides.length; l++) if (e.slides[l].item === i) {
						s.index = l;
						break
					}
				} else a = Q.list.matchingItems, e.slides = [], a.forEach((function (t, a) {
					var n = t._values;
					if (n && n.is_readable && n.is_popup) {
						var o = {pid: encodeURIComponent(n.basename), item: n};
						if (te && n.is_pano) Object.assign(o, {type: "pano", html: '<div class="popup-pano-placeholder">' + U.get_svg_icon("panorama_variant") + "</div>"}); else if (n.browser_image) {
							var l = !!_c.load_images && t.elm.firstElementChild, c = !Y.image_orientation && T(n.image), p = l && !c;
							if (Object.assign(o, {
								type: "image",
								src: r(n),
								w: n.image ? n.image.width || (p ? l.naturalWidth : 0) || screen.availWidth : screen.availHeight,
								h: n.image && (n.image.height || (p ? l.naturalHeight : 0)) || screen.availHeight,
								img_el: l,
								msrc: !(!p || !l.complete) && l.getAttribute("src")
							}), c && (o.w = n.image.height, o.h = n.image.width), p && !o.msrc && (l.onload = function () {
								o.msrc = this.getAttribute("src")
							}), "ico" === n.ext && o.w <= 16) {
								var d = 256 / o.w;
								o.w *= d, o.h *= d
							}
						} else n.is_browser_video && Object.assign(o, {type: "video", html: `<video class="popup-video" playsinline disablepictureinpicture controls controlsList="nodownload" loop><source src="${r(n)}${Y.only_touch ? "#t=0.001" : ""}" type="${n.mime}"></video>`});
						n === i && (s.index = e.slides.length), e.slides.push(o)
					}
				}));
				e.slides.length && (Z(), document.documentElement.classList.add("popup-open"), e.is_open = !0, e.caption_transition_delay = 333, e.container.classList.toggle("pswp__container-multi", e.slides.length > 1), "topbar" !== c.caption_style && X.filter.value && (e.search.innerHTML = U.get_svg_icon("image_search_outline") + '"' + n(X.filter.value) + '"'), e.slides.length < 3 && (s.playEl = !1), t = new ge(e.pswp, fe, e.slides, Object.assign({}, c, s, {
					arrowEl: e.slides.length > 1 && (!Y.only_touch || _c.current_dir.has_pano),
					arrowKeys: e.slides.length > 1,
					counterEl: e.slides.length > 1,
					showAnimationDuration: o ? 0 : 333,
					showHideOpacity: (() => {
						if (o) return !1;
						let t = e.slides[s.index];
						return !t.msrc || !t.img_el.offsetWidth
					})()
				})), Y.is_touch && t.listen("zoomGestureEnded", (function () {
					t.getZoomLevel() > t.currItem.initialZoomLevel && e.toggle_play(!1)
				})), t.listen("beforeChange", (function () {
					m(), e.toggle_timer(!1)
				})), t.listen("afterChange", (function () {
					var i, a = t.currItem.type;
					if (e.toggle_timer(!0), ["video", "pano"].forEach((t => e.ui.classList.toggle("popup-ui-" + t, a == t))), e.current_video = "video" === a && (!(!(i = t.currItem.container.firstElementChild) || "VIDEO" != i.nodeName) && i), e.current_video && c.video_autoplay && e.current_video.play(), function (i) {
						if (!!i == !!e.pano_viewer) return;
						Object.assign(t.options, {pinchToClose: !i, closeOnScroll: !i, closeOnVerticalDrag: !i, arrowKeys: !i && e.slides.length > 1})
					}("pano" == a), b(), "pano" == a) {
						var n = t.currItem;
						U.load_plugin("pannellum", (() => {
							n === t.currItem && (e.pano_viewer = pannellum.viewer(e.pano_container, {type: "equirectangular", panorama: n.item.is_pano, autoLoad: !0, autoRotate: e.pano_is_rotating ? -2 : 0, autoRotateInactivityDelay: 3e3, showControls: !1, hfov: window.innerWidth > window.innerHeight ? 105 : 75}))
						}))
					}
				})), t.listen("imageLoadComplete", (function (i, a) {
					t.options.playEl && i === t.getCurrentIndex() && e.toggle_timer(!0)
				})), t.listen("close", (function () {
					m(), e.current_video = !1, e.toggle_play(!1), document.documentElement.classList.remove("popup-open")
				})), t.listen("destroy", (function () {
					e.preloader.classList.remove("pswp__spinner");
					for (var t = 0; t < e.items.length; t++) d(e.items[t]);
					b(), d(e.search), e.is_open = !1
				})), t.init())
			}
		}, e.toggle_play = function (t) {
			t === e.playing || t && u() || (e.playing = !!t, _e.toggle_class(e.play_button, "is-playing", t), e.toggle_timer(t))
		}, e.toggle_timer = function (i) {
			if (i && u()) return e.toggle_play(!1);
			if ((!i || e.playing && (t.currItem.loaded || !t.currItem.src)) && e.timer != i) {
				e.timer = !!i, i && (e.play_timer.style.opacity = 1), anime.remove(e.play_timer);
				var a = {targets: e.play_timer, duration: i ? t.options.play_interval : 333, easing: i ? "easeInOutCubic" : "easeOutQuad", scaleX: i ? [0, 1] : 0};
				i ? (a.begin = function () {
					e.play_timer.style.display = "block"
				}, a.complete = function () {
					t.next(!0)
				}) : (a.complete = function () {
					e.play_timer.style.display = "none"
				}, a.opacity = [1, 0]), anime(a)
			}
		}, e.pano_is_rotating = !1 !== j.get("files:popup:pano:rotating"), document.body.insertAdjacentHTML("beforeend", '\t\t<div class="pswp' + (Y.is_touch ? " pswp--touch" : "") + (Y.only_pointer ? " pswp--has_mouse" : "") + '" tabindex="-1" role="dialog" aria-hidden="true">\t    \t<div class="pswp__bg"></div>\t    \t<div class="pswp__scroll-wrap">\t    \t\t<div class="pswp__container' + (_c.server_exif ? " server-exif" : "") + '">\t\t        <div class="pswp__item"></div>\t\t        <div class="pswp__item"></div>\t\t        <div class="pswp__item"></div>\t        </div>\t        <div class="pswp__ui pswp__ui--hidden pswp__caption-align-' + c.caption_align + '">\t          <div class="pswp__top-bar">\t            <div class="pswp__counter"></div>\t            <div class="pswp__search"></div>\t            <div class="pswp__topbar-spacer"></div>\t            <span class="pswp__preloader"></span>' + (c.downloadEl ? '<a type="button" class="button-icon pswp__button pswp__button--download"' + x(Y.download ? "download" : "open in new tab") + ' target="_blank"' + (Y.download ? " download" : "") + ">" + U.get_svg_icon(Y.download ? "download" : "open_in_new") + "</a>" : _(!0, "button-icon pswp__button")) + '\t\t\t\t\t\t\t<button class="button-icon pswp__button pswp__button--pano-rotate' + (e.pano_is_rotating ? " is-rotating" : "") + '">' + U.get_svg_icon_multi("motion_play_outline", "motion_pause_outline") + "</button>" + (Y.only_touch ? "" : '<button class="button-icon pswp__button pswp__button--zoom">' + U.get_svg_icon_multi("magnify_plus", "magnify_minus") + "</button>") + '\t            <button class="button-icon pswp__button pswp__button--play">' + U.get_svg_icon_multi("play", "pause") + "</button>\t            " + (Y.fullscreen ? '<button class="button-icon pswp__button pswp__button--fs">' + U.get_svg_icon_multi("expand", "collapse") + "</button>" : "") + '\t            <button class="button-icon pswp__button pswp__button--close">' + U.get_svg_icon("close_thin") + '</button>\t          </div>\t          <button class="pswp__button pswp__button--arrow--left">' + U.get_svg_icon("chevron_left") + '</button><button class="pswp__button pswp__button--arrow--right">' + U.get_svg_icon("chevron_right") + '</button>\t          <div class="pswp__timer"></div>\t          <div class="pswp__caption pswp__caption-style-' + c.caption_style + (c.caption_hide ? " pswp__caption-hide" : "") + (o ? " pswp__caption-locked" : "") + '">\t          \t' + (Y.only_touch ? "" : '<button class="button-icon pswp__button--lock-caption">' + U.get_svg_icon_multi("lock_outline", "lock_open_outline") + "</button>") + '\t          \t<div class="pswp__caption__center"></div>\t          </div>\t        </div>\t    \t</div>\t\t\t\t<div class="pswp__pano"></div>\t\t\t</div>'), e.pswp = document.body.lastElementChild, e.bg = e.pswp.firstElementChild, e.scrollwrap = e.pswp.children[1], e.pano_container = e.pswp.lastElementChild, e.container = e.scrollwrap.firstElementChild, e.items = e.container.children, e.ui = e.scrollwrap.lastElementChild, e.topbar = e.ui.firstElementChild, e.ArrowLeft = e.ui.children[1], e.ArrowRight = e.ui.children[2], e.caption = e.ui.lastElementChild, e.caption_center = e.caption.lastElementChild, e.play_timer = e.ui.children[3], Array.from(e.topbar.children).forEach((function (t) {
			var i = t.classList;
			return i.contains("pswp__preloader") ? e.preloader = t : i.contains("pswp__button--play") ? e.play_button = t : i.contains("pswp__search") ? e.search = t : i.contains("context-button") ? e.contextmenu_button = t : i.contains("pswp__button--pano-rotate") ? e.pano_rotate_button = t : void 0
		})), e.toggle_pano_rotate = () => {
			if (e.pano_viewer) {
				if (e.pano_is_rotating = !e.pano_is_rotating, e.pano_viewer[(e.pano_is_rotating ? "start" : "stop") + "AutoRotate"](), e.pano_is_rotating) {
					var t = e.pano_viewer.getConfig();
					t.autoRotate = -2, t.autoRotateInactivityDelay = 3e3
				}
				j.set("files:popup:pano:rotating", !!e.pano_is_rotating), e.pano_rotate_button.classList.toggle("is-rotating", e.pano_is_rotating)
			}
		}, e.caption.addEventListener("click", (function (i) {
			return i.target.classList.contains("pswp__button--lock-caption") ? (o = !o, _e.toggle_class(e.caption, "pswp__caption-locked", o), j.set("files:popup:locked_caption", o, !0)) : "context" == i.target.dataset.action ? U.create_contextmenu(i, "popup", i.target, t.currItem.item) : void (Y.is_pointer && 0 === i.target.className.indexOf("pswp") && ("right" === c.caption_align && i.pageX > this.clientWidth - 49 ? t.next() : "left" === c.caption_align && i.pageX < 49 && t.prev()))
		})), Y.is_pointer && e.contextmenu_button && C(e.contextmenu_button, (function (e) {
			U.create_contextmenu(e, "popup", e.target, t.currItem.item)
		}))
	})();

	class me {
		static actions = {
			move: "folder_move_outline",
			copy: "content_copy",
			duplicate: "content_duplicate",
			zip: !!_c.ZipArchive_enabled && "zip_box_outline",
			unzip: !!_c.ZipArchive_enabled && "unzip",
			delete: "delete_outline",
			"copy links": !(!_c.allow_mass_copy_links || !Y.url) && "link",
			download: !(!_c.allow_mass_download || !Y.download) && "tray_arrow_down",
			rename: "rename_outline"
		};
		static keyboard_shortcuts = {a: !0, i: !0, c: _c.allow_copy, v: _c.allow_copy, n: _c.allow_rename, Backspace: _c.allow_delete, d: _c.allow_duplicate};
		static config = t("select", {enabled: !0, buttons: Object.keys(this.actions), mode: !1, mode_button: !0, display: "select-mode", copy_links_separator: ", ", keyboard_shortcuts: Object.keys(this.keyboard_shortcuts)});
		static el = {};
		static buttons = [];
		static buttons_contextmenu = [];
		static count = 0;
		static mode = !1;
		static anchor = 0;
		static focus = 0;

		static headroom_pin(e) {
			let t = Q.headroom;
			t && (e && e.y && e.y < t.elem.clientHeight || t.pin())
		}

		static select(e, t) {
			if (!!e.dataset.selected != !!t) return this.count += t ? 1 : -1, t ? e.dataset.selected = 1 : delete e.dataset.selected
		}

		static range(e, t) {
			if (/*!toggle && */this.focus == this.anchor) return;
			let i = Math.min(this.anchor, this.focus), a = Math.max(this.anchor, this.focus);
			for (var n = i; n <= a; n++) e[n] = !!t
		}

		static click(e, t) {
			if (!this.config.enabled) return;
			const i = e.target.classList.contains("svg-check-select");
			if (!this.mode && !i) return;
			if (!i && ["alt", "ctrl", "meta"].some((t => e[t + "Key"]))) return;
			const a = Array.from(X.files.children).indexOf(t);
			if (e.shiftKey) {
				const t = {};
				this.range(t, !1), this.focus = a, this.range(t, !0), Object.keys(t).forEach((e => this.select(X.files.children[e], t[e]))), this.count && this.headroom_pin(e)
			} else {
				this.anchor = this.focus = a;
				const i = !t.dataset.selected;
				this.select(t, i), i && this.headroom_pin(e)
			}
			return this.interface(), !0
		}

		static matchingItems_length() {
			return Q.list ? Math.min(Q.list.matchingItems.length, Q.list.items.length) : 0
		}

		static all(e) {
			const t = this.matchingItems_length();
			if (!t) return;
			const i = !this.count || !!(e && this.count < t);
			Q.list.matchingItems.forEach((e => this.select(e.elm, i))), this.interface(), i && this.headroom_pin()
		}

		static selected() {
			return this.matchingItems_length() ? Q.list.matchingItems.filter((e => e.elm.dataset.selected)) : []
		}

		static toggle_has_matchingItems(e) {
			this.el.selectbar.classList.toggle("has-matchingItems", e), this.el.selectbar.firstElementChild.disabled = !e
		}

		static update() {
			this.config.enabled && (this.count = this.selected().length, this.toggle_has_matchingItems(!!this.matchingItems_length()), this.interface())
		}

		static reset(e) {
			this.config.enabled && (this.anchor = this.focus = 0, this.toggle_has_matchingItems(!!e), this.count && (this.count = 0, this.interface()))
		}

		static interface() {
			this.el.counter.textContent = this.count || "", this.el.selectbar.classList.toggle("has-selection", !!this.count), this.el.selectbar.classList.toggle("select-single", 1 === this.count), this.el.selectbar.classList.toggle("select-multiple", this.count > 1), this.el.selectbar.classList.toggle("select-is-zip", 1 === this.count && "zip" === this.selected()[0]._values.ext), this.el.buttons.forEach((e => e.disabled = !this.count))
		}

		static set_mode(e) {
			this.mode = !!e, X.main.classList.toggle("select-mode", this.mode), X.main.classList.toggle("select-mode-disabled", !this.mode)
		}

		static copy_links(e) {
			const t = [];
			return e.forEach((e => {
				try {
					const i = new URL(c(e), location);
					i && i.href && t.push(i.href)
				} catch (e) {
					return
				}
			})), t.length && b(t.join(this.config.copy_links_separator))
		}

		static copied_items = [];
		static copied_items_parent;

		static paste_items() {
			if (!(_c.current_dir && this.copied_items.length && this.copied_items_parent && this.copied_items_parent.files)) return;
			if (_c.dirs[this.copied_items_parent.path] !== this.copied_items_parent) return;
			if (this.copied_items = this.copied_items.filter((e => {
				let t = this.copied_items_parent.files[e.basename];
				if (t) return t === e || ["basename", "filesize", "mtime", "path"].every((i => t[i] === e[i]))
			})), !this.copied_items.length) return;
			const e = this.copied_items_parent === _c.current_dir ? "duplicate" : "copy";
			return new se({action: e, items: this.copied_items, pasted_from: "copy" === e && this.copied_items_parent, parent_dir: this.copied_items_parent, parent_path: this.copied_items_parent.path})
		}

		static select_action(e) {
			if ("toggle" === e) return this.all();
			const t = this.count ? this.selected() : [];
			if (!t.length) return F.toggle(!1, "Nothing selected!");
			const i = t.map((e => e._values));
			return "copy links" === e ? te ? F.toggle(this.copy_links(i), J.get("copy link" + (i.length > 1 ? "s" : ""))) : F.license() : "download" === e ? ne.zip(_c.current_dir, i.filter((e => e.is_readable))) : "copy_items" === e ? (this.copied_items = i, this.copied_items_parent = _c.current_dir, F.toggle(!0, `${i.length} ${J.get(se.get_items_type(i))} ${J.get("copied to clipboard")}`)) : "modal" === e ? 1 === i.length && U.open_modal(i[0], !0) : new se({
				action: e,
				items: i,
				list_items: t,
				parent_dir: _c.current_dir,
				parent_path: _c.current_path
			})
		}

		static keyboard_events() {
			if (!this.config.keyboard_shortcuts || !this.config.keyboard_shortcuts.length) return;
			const e = this.config.keyboard_shortcuts.filter((e => this.keyboard_shortcuts[e]));
			e.length && document.addEventListener("keydown", (t => {
				if (Q.modal.open || Q.popup.is_open || !_c.current_dir) return;
				const i = t.key;
				if ((t[Y.modKey] || "n" === i) && !["INPUT", "SELECT", "TEXTAREA"].includes(t.target.nodeName) && e.includes(i) && (t.preventDefault(), !t.repeat)) {
					if ("v" === i) return this.paste_items();
					if ("a" === i) return me.all(!0);
					if (this.count) return "n" === i ? 1 === this.count && this.select_action("rename") : "Backspace" === i ? this.select_action("delete") : "d" === i ? this.select_action("duplicate") : "c" === i ? this.select_action("copy_items") : "i" === i ? 1 === this.count && this.select_action("modal") : void 0
				}
			}))
		}

		static init() {
			if (!this.config.enabled) return;
			if (this.buttons = this.config.buttons ? this.config.buttons.filter((e => {
				if (this.actions[e]) return _c[`allow_${e}`] || !_c.hasOwnProperty(`allow_${e}`)
			})) : [], !this.buttons.length) return this.config.enabled = !1;
			X.files_container.classList.add("select-enabled"), this.buttons_contextmenu = this.buttons.filter((e => !["rename", "unzip"].includes(e))), this.config.mode_button && (X.topbar_top.insertAdjacentHTML("beforeend", `<button class="button-icon" id="select-mode-button" data-lang="selection mode" data-tooltip="${J.get("selection mode")}">${U.get_svg_icon_multi("check", "check_all")}</button>`), C(X.topbar_top.lastElementChild, (e => {
				this.set_mode(!this.mode), j.set("files:select:mode", this.mode ? "on" : "off")
			}))), this.el.selectbar = _query(".topbar-select"), this.el.selectbar.classList.add("select-display-" + this.config.display), this.el.selectbar.innerHTML = `<button class="button-icon button-select-toggle" data-action="toggle" title="${Y.c_key}+A" data-lang="select all" data-tooltip="${J.get("select all")}" disabled>${U.get_svg_icon_multi("check", "close_thin")}<span class="selected-count"></span></button><div class="buttons-selected">${V(this.buttons, (e => `<button class="button-icon button-selected-action" data-action="${e}" data-lang="${e}" data-tooltip="${J.get(e)}" disabled>${U.get_svg_icon(this.actions[e])}</button>`))}</div>`, this.el.select_all_button = this.el.selectbar.firstElementChild, this.el.counter = this.el.selectbar.querySelector(".selected-count"), this.el.buttons = Array.from(this.el.selectbar.lastElementChild.children), m(this.el.selectbar, ((e, t) => this.select_action(e)));
			let e = !!this.config.mode_button && j.get("files:select:mode");
			this.set_mode("on" === e || !e && this.config.mode), this.keyboard_events()
		}
	}

	me.init();
	const ue = (() => {
		j.remove("swal-initiation");
		const e = Swal.mixin({
			scrollbarPadding: !1,
			showCloseButton: !1,
			closeButtonHtml: U.get_svg_icon("close_thin"),
			buttonsStyling: !1,
			reverseButtons: !Y.ua || -1 === Y.ua.indexOf("Win"),
			showCancelButton: !0,
			cancelButtonText: J.get("cancel"),
			customClass: {confirmButton: "button", cancelButton: "button button-secondary", input: "input", closeButton: "button-icon"},
			willOpen: () => Z(),
			heightAuto: !1
		});
		return {
			default: e.mixin(), prompt: e.mixin({
				input: "text", inputAttributes: {maxlength: 127, autocapitalize: "off", autocorrect: "off", autocomplete: "off", spellcheck: "false"}, didOpen: () => {
					if (!Y.is_pointer) return;
					let e = Swal.getInput();
					if (!e || !e.value || e !== document.activeElement) return;
					let t = e.value.lastIndexOf(".");
					if (t < 1) return e.select();
					e.setSelectionRange(0, t)
				}
			}), confirm: e.mixin({title: "Confirm?"}), invalid_response: e => U.get_svg_icon("alert_circle_outline") + e
		}
	})();
	(() => {
		var e = document.body;

		function t(t) {
			e.dataset.updated = t, e.style.cursor = "pointer";
			var i = L(e, "click", (function () {
				e.classList.remove("updated"), e.removeAttribute("data-updated"), e.style.removeProperty("cursor"), i.remove()
			}))
		}

		_c.allow_check_updates && (j.get("files:updated") ? (j.remove("files:updated"), t("✓ Successfully updated to Files app version " + _c.version), e.classList.add("updated")) : I({
			json_response: !0, params: "action=check_updates", url: _c.script + "?action=check_updates", complete: function (i, a, n) {
				if (i && a && n && i.hasOwnProperty("success")) {
					var o = i.success;
					if (E(o ? "New version " + o + " available." : "Already using latest version " + _c.version), o) {
						_id("change-sort").insertAdjacentHTML("afterend", '<div id="files-notifications" class="dropdown"><button type="button" class="button-icon">' + U.get_svg_icon("bell") + '</button><div class="dropdown-menu dropdown-menu-topbar"><span class="dropdown-header">Files Gallery ' + o + "</span>" + (i.writeable ? '<button class="dropdown-item">' + U.get_svg_icon("rotate_right") + '<span class="dropdown-text" data-lang="update">' + J.get("update") + "</span></button>" : "") + (Y.download ? '<a href="https://cdn.jsdelivr.net/npm/files.photo.gallery@' + o + '/index.php" class="dropdown-item" download>' + U.get_svg_icon("download") + '<span class="dropdown-text" data-lang="download">' + J.get("download") + "</span></a>" : "") + '<a href="https://files.photo.gallery/latest" class="dropdown-item" target="_blank">' + U.get_svg_icon("info") + '<span class="dropdown-text" data-lang="read more">' + J.get("read more") + "</span></a></div></div>");
						var s = _id("files-notifications");
						if (U.dropdown(s, s.firstChild), !i.writeable) return;
						C(s.children[1].children[1], (() => {
							ue.confirm.fire({title: J.get("update"), text: "Update to Files Gallery " + o + "?", cancelButtonText: J.get("cancel"), confirmButtonText: J.get("update")}).then((i => {
								i.isConfirmed && (e.classList.add("updating"), I({
									params: "version=" + o, url: _c.script + "?action=do_update", json_response: !0, complete: function (i, a, n) {
										if (e.classList.add("updated"), e.classList.remove("updating"), i && a && n && i.hasOwnProperty("success") && i.success) {
											j.set("files:updated", !0);
											try {
												e.dataset.updated = "✓ Success! Reloading ...";
												var s = location.href;
												location.href = s.split("#")[0] + (s.indexOf("?") > 0 ? "&" : "?") + "version=" + o
											} catch (t) {
												e.dataset.updated = "✓ Success! Please refresh ..."
											}
										} else t("✗ Failed to load update :(")
									}
								}))
							}))
						}))
					}
				} else E("Failed to load external JSON check_updates.")
			}
		}))
	})(), window.onpopstate = function (e) {
		_c.history && e.state && e.state.hasOwnProperty("path") && U.get_files(e.state.path)
	};
	var he = {
		123: "application/vnd.lotus-1-2-3",
		ez: "application/andrew-inset",
		aw: "application/applixware",
		atom: "application/atom+xml",
		atomcat: "application/atomcat+xml",
		atomdeleted: "application/atomdeleted+xml",
		atomsvc: "application/atomsvc+xml",
		dwd: "application/atsc-dwd+xml",
		held: "application/atsc-held+xml",
		rsat: "application/atsc-rsat+xml",
		bdoc: "application/x-bdoc",
		xcs: "application/calendar+xml",
		ccxml: "application/ccxml+xml",
		cdfx: "application/cdfx+xml",
		cdmia: "application/cdmi-capability",
		cdmic: "application/cdmi-container",
		cdmid: "application/cdmi-domain",
		cdmio: "application/cdmi-object",
		cdmiq: "application/cdmi-queue",
		cu: "application/cu-seeme",
		mpd: "application/dash+xml",
		davmount: "application/davmount+xml",
		dbk: "application/docbook+xml",
		dssc: "application/dssc+der",
		xdssc: "application/dssc+xml",
		ecma: "application/ecmascript",
		es: "application/ecmascript",
		emma: "application/emma+xml",
		emotionml: "application/emotionml+xml",
		epub: "application/epub+zip",
		exi: "application/exi",
		fdt: "application/fdt+xml",
		pfr: "application/font-tdpfr",
		geojson: "application/geo+json",
		gml: "application/gml+xml",
		gpx: "application/gpx+xml",
		gxf: "application/gxf",
		gz: "application/gzip",
		hjson: "application/hjson",
		stk: "application/hyperstudio",
		ink: "application/inkml+xml",
		inkml: "application/inkml+xml",
		ipfix: "application/ipfix",
		its: "application/its+xml",
		jar: "application/java-archive",
		war: "application/java-archive",
		ear: "application/java-archive",
		ser: "application/java-serialized-object",
		class: "application/java-vm",
		js: "application/javascript",
		mjs: "application/javascript",
		json: "application/json",
		map: "application/json",
		json5: "application/json5",
		jsonml: "application/jsonml+json",
		jsonld: "application/ld+json",
		lgr: "application/lgr+xml",
		lostxml: "application/lost+xml",
		hqx: "application/mac-binhex40",
		cpt: "application/mac-compactpro",
		mads: "application/mads+xml",
		webmanifest: "application/manifest+json",
		mrc: "application/marc",
		mrcx: "application/marcxml+xml",
		ma: "application/mathematica",
		nb: "application/mathematica",
		mb: "application/mathematica",
		mathml: "application/mathml+xml",
		mbox: "application/mbox",
		mscml: "application/mediaservercontrol+xml",
		metalink: "application/metalink+xml",
		meta4: "application/metalink4+xml",
		mets: "application/mets+xml",
		maei: "application/mmt-aei+xml",
		musd: "application/mmt-usd+xml",
		mods: "application/mods+xml",
		m21: "application/mp21",
		mp21: "application/mp21",
		mp4s: "application/mp4",
		m4p: "application/mp4",
		xdf: "application/xcap-diff+xml",
		doc: "application/msword",
		dot: "application/msword",
		mxf: "application/mxf",
		nq: "application/n-quads",
		nt: "application/n-triples",
		cjs: "application/node",
		bin: "application/octet-stream",
		dms: "application/octet-stream",
		lrf: "application/octet-stream",
		mar: "application/octet-stream",
		so: "application/octet-stream",
		dist: "application/octet-stream",
		distz: "application/octet-stream",
		pkg: "application/octet-stream",
		bpk: "application/octet-stream",
		dump: "application/octet-stream",
		elc: "application/octet-stream",
		deploy: "application/octet-stream",
		exe: "application/x-msdownload",
		dll: "application/x-msdownload",
		deb: "application/x-debian-package",
		dmg: "application/x-apple-diskimage",
		iso: "application/x-iso9660-image",
		img: "application/octet-stream",
		msi: "application/x-msdownload",
		msp: "application/octet-stream",
		msm: "application/octet-stream",
		buffer: "application/octet-stream",
		oda: "application/oda",
		opf: "application/oebps-package+xml",
		ogx: "application/ogg",
		omdoc: "application/omdoc+xml",
		onetoc: "application/onenote",
		onetoc2: "application/onenote",
		onetmp: "application/onenote",
		onepkg: "application/onenote",
		oxps: "application/oxps",
		relo: "application/p2p-overlay+xml",
		xer: "application/xcap-error+xml",
		pdf: "application/pdf",
		pgp: "application/pgp-encrypted",
		asc: "application/pgp-signature",
		sig: "application/pgp-signature",
		prf: "application/pics-rules",
		p10: "application/pkcs10",
		p7m: "application/pkcs7-mime",
		p7c: "application/pkcs7-mime",
		p7s: "application/pkcs7-signature",
		p8: "application/pkcs8",
		ac: "application/vnd.nokia.n-gage.ac+xml",
		cer: "application/pkix-cert",
		crl: "application/pkix-crl",
		pkipath: "application/pkix-pkipath",
		pki: "application/pkixcmp",
		pls: "application/pls+xml",
		ai: "application/postscript",
		eps: "application/postscript",
		ps: "application/postscript",
		provx: "application/provenance+xml",
		cww: "application/prs.cww",
		pskcxml: "application/pskc+xml",
		raml: "application/raml+yaml",
		rdf: "application/rdf+xml",
		owl: "application/rdf+xml",
		rif: "application/reginfo+xml",
		rnc: "application/relax-ng-compact-syntax",
		rl: "application/resource-lists+xml",
		rld: "application/resource-lists-diff+xml",
		rs: "application/rls-services+xml",
		rapd: "application/route-apd+xml",
		sls: "application/route-s-tsid+xml",
		rusd: "application/route-usd+xml",
		gbr: "application/rpki-ghostbusters",
		mft: "application/rpki-manifest",
		roa: "application/rpki-roa",
		rsd: "application/rsd+xml",
		rss: "application/rss+xml",
		rtf: "text/rtf",
		sbml: "application/sbml+xml",
		scq: "application/scvp-cv-request",
		scs: "application/scvp-cv-response",
		spq: "application/scvp-vp-request",
		spp: "application/scvp-vp-response",
		sdp: "application/sdp",
		senmlx: "application/senml+xml",
		sensmlx: "application/sensml+xml",
		setpay: "application/set-payment-initiation",
		setreg: "application/set-registration-initiation",
		shf: "application/shf+xml",
		siv: "application/sieve",
		sieve: "application/sieve",
		smi: "application/smil+xml",
		smil: "application/smil+xml",
		rq: "application/sparql-query",
		srx: "application/sparql-results+xml",
		gram: "application/srgs",
		grxml: "application/srgs+xml",
		sru: "application/sru+xml",
		ssdl: "application/ssdl+xml",
		ssml: "application/ssml+xml",
		swidtag: "application/swid+xml",
		tei: "application/tei+xml",
		teicorpus: "application/tei+xml",
		tfi: "application/thraud+xml",
		tsd: "application/timestamped-data",
		toml: "application/toml",
		ttml: "application/ttml+xml",
		rsheet: "application/urc-ressheet+xml",
		"1km": "application/vnd.1000minds.decision-model+xml",
		plb: "application/vnd.3gpp.pic-bw-large",
		psb: "application/vnd.3gpp.pic-bw-small",
		pvb: "application/vnd.3gpp.pic-bw-var",
		tcap: "application/vnd.3gpp2.tcap",
		pwn: "application/vnd.3m.post-it-notes",
		aso: "application/vnd.accpac.simply.aso",
		imp: "application/vnd.accpac.simply.imp",
		acu: "application/vnd.acucobol",
		atc: "application/vnd.acucorp",
		acutc: "application/vnd.acucorp",
		air: "application/vnd.adobe.air-application-installer-package+zip",
		fcdt: "application/vnd.adobe.formscentral.fcdt",
		fxp: "application/vnd.adobe.fxp",
		fxpl: "application/vnd.adobe.fxp",
		xdp: "application/vnd.adobe.xdp+xml",
		xfdf: "application/vnd.adobe.xfdf",
		ahead: "application/vnd.ahead.space",
		azf: "application/vnd.airzip.filesecure.azf",
		azs: "application/vnd.airzip.filesecure.azs",
		azw: "application/vnd.amazon.ebook",
		acc: "application/vnd.americandynamics.acc",
		ami: "application/vnd.amiga.ami",
		apk: "application/vnd.android.package-archive",
		cii: "application/vnd.anser-web-certificate-issue-initiation",
		fti: "application/vnd.anser-web-funds-transfer-initiation",
		atx: "application/vnd.antix.game-component",
		mpkg: "application/vnd.apple.installer+xml",
		keynote: "application/vnd.apple.keynote",
		m3u8: "application/vnd.apple.mpegurl",
		numbers: "application/vnd.apple.numbers",
		pages: "application/vnd.apple.pages",
		pkpass: "application/vnd.apple.pkpass",
		swi: "application/vnd.aristanetworks.swi",
		iota: "application/vnd.astraea-software.iota",
		aep: "application/vnd.audiograph",
		bmml: "application/vnd.balsamiq.bmml+xml",
		mpm: "application/vnd.blueice.multipass",
		bmi: "application/vnd.bmi",
		rep: "application/vnd.businessobjects",
		cdxml: "application/vnd.chemdraw+xml",
		mmd: "application/vnd.chipnuts.karaoke-mmd",
		cdy: "application/vnd.cinderella",
		csl: "application/vnd.citationstyles.style+xml",
		cla: "application/vnd.claymore",
		rp9: "application/vnd.cloanto.rp9",
		c4g: "application/vnd.clonk.c4group",
		c4d: "application/vnd.clonk.c4group",
		c4f: "application/vnd.clonk.c4group",
		c4p: "application/vnd.clonk.c4group",
		c4u: "application/vnd.clonk.c4group",
		c11amc: "application/vnd.cluetrust.cartomobile-config",
		c11amz: "application/vnd.cluetrust.cartomobile-config-pkg",
		csp: "application/vnd.commonspace",
		cdbcmsg: "application/vnd.contact.cmsg",
		cmc: "application/vnd.cosmocaller",
		clkx: "application/vnd.crick.clicker",
		clkk: "application/vnd.crick.clicker.keyboard",
		clkp: "application/vnd.crick.clicker.palette",
		clkt: "application/vnd.crick.clicker.template",
		clkw: "application/vnd.crick.clicker.wordbank",
		wbs: "application/vnd.criticaltools.wbs+xml",
		pml: "application/vnd.ctc-posml",
		ppd: "application/vnd.cups-ppd",
		car: "application/vnd.curl.car",
		pcurl: "application/vnd.curl.pcurl",
		dart: "application/vnd.dart",
		rdz: "application/vnd.data-vision.rdz",
		uvf: "application/vnd.dece.data",
		uvvf: "application/vnd.dece.data",
		uvd: "application/vnd.dece.data",
		uvvd: "application/vnd.dece.data",
		uvt: "application/vnd.dece.ttml+xml",
		uvvt: "application/vnd.dece.ttml+xml",
		uvx: "application/vnd.dece.unspecified",
		uvvx: "application/vnd.dece.unspecified",
		uvz: "application/vnd.dece.zip",
		uvvz: "application/vnd.dece.zip",
		fe_launch: "application/vnd.denovo.fcselayout-link",
		dna: "application/vnd.dna",
		mlp: "application/vnd.dolby.mlp",
		dpg: "application/vnd.dpgraph",
		dfac: "application/vnd.dreamfactory",
		kpxx: "application/vnd.ds-keypoint",
		ait: "application/vnd.dvb.ait",
		svc: "application/vnd.dvb.service",
		geo: "application/vnd.dynageo",
		mag: "application/vnd.ecowin.chart",
		nml: "application/vnd.enliven",
		esf: "application/vnd.epson.esf",
		msf: "application/vnd.epson.msf",
		qam: "application/vnd.epson.quickanime",
		slt: "application/vnd.epson.salt",
		ssf: "application/vnd.epson.ssf",
		es3: "application/vnd.eszigno3+xml",
		et3: "application/vnd.eszigno3+xml",
		ez2: "application/vnd.ezpix-album",
		ez3: "application/vnd.ezpix-package",
		fdf: "application/vnd.fdf",
		mseed: "application/vnd.fdsn.mseed",
		seed: "application/vnd.fdsn.seed",
		dataless: "application/vnd.fdsn.seed",
		gph: "application/vnd.flographit",
		ftc: "application/vnd.fluxtime.clip",
		fm: "application/vnd.framemaker",
		frame: "application/vnd.framemaker",
		maker: "application/vnd.framemaker",
		book: "application/vnd.framemaker",
		fnc: "application/vnd.frogans.fnc",
		ltf: "application/vnd.frogans.ltf",
		fsc: "application/vnd.fsc.weblaunch",
		oas: "application/vnd.fujitsu.oasys",
		oa2: "application/vnd.fujitsu.oasys2",
		oa3: "application/vnd.fujitsu.oasys3",
		fg5: "application/vnd.fujitsu.oasysgp",
		bh2: "application/vnd.fujitsu.oasysprs",
		ddd: "application/vnd.fujixerox.ddd",
		xdw: "application/vnd.fujixerox.docuworks",
		xbd: "application/vnd.fujixerox.docuworks.binder",
		fzs: "application/vnd.fuzzysheet",
		txd: "application/vnd.genomatix.tuxedo",
		ggb: "application/vnd.geogebra.file",
		ggt: "application/vnd.geogebra.tool",
		gex: "application/vnd.geometry-explorer",
		gre: "application/vnd.geometry-explorer",
		gxt: "application/vnd.geonext",
		g2w: "application/vnd.geoplan",
		g3w: "application/vnd.geospace",
		gmx: "application/vnd.gmx",
		gdoc: "application/vnd.google-apps.document",
		gslides: "application/vnd.google-apps.presentation",
		gsheet: "application/vnd.google-apps.spreadsheet",
		kml: "application/vnd.google-earth.kml+xml",
		kmz: "application/vnd.google-earth.kmz",
		gqf: "application/vnd.grafeq",
		gqs: "application/vnd.grafeq",
		gac: "application/vnd.groove-account",
		ghf: "application/vnd.groove-help",
		gim: "application/vnd.groove-identity-message",
		grv: "application/vnd.groove-injector",
		gtm: "application/vnd.groove-tool-message",
		tpl: "application/vnd.groove-tool-template",
		vcg: "application/vnd.groove-vcard",
		hal: "application/vnd.hal+xml",
		zmm: "application/vnd.handheld-entertainment+xml",
		hbci: "application/vnd.hbci",
		les: "application/vnd.hhe.lesson-player",
		hpgl: "application/vnd.hp-hpgl",
		hpid: "application/vnd.hp-hpid",
		hps: "application/vnd.hp-hps",
		jlt: "application/vnd.hp-jlyt",
		pcl: "application/vnd.hp-pcl",
		pclxl: "application/vnd.hp-pclxl",
		"sfd-hdstx": "application/vnd.hydrostatix.sof-data",
		mpy: "application/vnd.ibm.minipay",
		afp: "application/vnd.ibm.modcap",
		listafp: "application/vnd.ibm.modcap",
		list3820: "application/vnd.ibm.modcap",
		irm: "application/vnd.ibm.rights-management",
		sc: "application/vnd.ibm.secure-container",
		icc: "application/vnd.iccprofile",
		icm: "application/vnd.iccprofile",
		igl: "application/vnd.igloader",
		ivp: "application/vnd.immervision-ivp",
		ivu: "application/vnd.immervision-ivu",
		igm: "application/vnd.insors.igm",
		xpw: "application/vnd.intercon.formnet",
		xpx: "application/vnd.intercon.formnet",
		i2g: "application/vnd.intergeo",
		qbo: "application/vnd.intu.qbo",
		qfx: "application/vnd.intu.qfx",
		rcprofile: "application/vnd.ipunplugged.rcprofile",
		irp: "application/vnd.irepository.package+xml",
		xpr: "application/vnd.is-xpr",
		fcs: "application/vnd.isac.fcs",
		jam: "application/vnd.jam",
		rms: "application/vnd.jcp.javame.midlet-rms",
		jisp: "application/vnd.jisp",
		joda: "application/vnd.joost.joda-archive",
		ktz: "application/vnd.kahootz",
		ktr: "application/vnd.kahootz",
		karbon: "application/vnd.kde.karbon",
		chrt: "application/vnd.kde.kchart",
		kfo: "application/vnd.kde.kformula",
		flw: "application/vnd.kde.kivio",
		kon: "application/vnd.kde.kontour",
		kpr: "application/vnd.kde.kpresenter",
		kpt: "application/vnd.kde.kpresenter",
		ksp: "application/vnd.kde.kspread",
		kwd: "application/vnd.kde.kword",
		kwt: "application/vnd.kde.kword",
		htke: "application/vnd.kenameaapp",
		kia: "application/vnd.kidspiration",
		kne: "application/vnd.kinar",
		knp: "application/vnd.kinar",
		skp: "application/vnd.koan",
		skd: "application/vnd.koan",
		skt: "application/vnd.koan",
		skm: "application/vnd.koan",
		sse: "application/vnd.kodak-descriptor",
		lasxml: "application/vnd.las.las+xml",
		lbd: "application/vnd.llamagraphics.life-balance.desktop",
		lbe: "application/vnd.llamagraphics.life-balance.exchange+xml",
		apr: "application/vnd.lotus-approach",
		pre: "application/vnd.lotus-freelance",
		nsf: "application/vnd.lotus-notes",
		org: "text/x-org",
		scm: "application/vnd.lotus-screencam",
		lwp: "application/vnd.lotus-wordpro",
		portpkg: "application/vnd.macports.portpkg",
		mcd: "application/vnd.mcd",
		mc1: "application/vnd.medcalcdata",
		cdkey: "application/vnd.mediastation.cdkey",
		mwf: "application/vnd.mfer",
		mfm: "application/vnd.mfmp",
		flo: "application/vnd.micrografx.flo",
		igx: "application/vnd.micrografx.igx",
		mif: "application/vnd.mif",
		daf: "application/vnd.mobius.daf",
		dis: "application/vnd.mobius.dis",
		mbk: "application/vnd.mobius.mbk",
		mqy: "application/vnd.mobius.mqy",
		msl: "application/vnd.mobius.msl",
		plc: "application/vnd.mobius.plc",
		txf: "application/vnd.mobius.txf",
		mpn: "application/vnd.mophun.application",
		mpc: "application/vnd.mophun.certificate",
		xul: "application/vnd.mozilla.xul+xml",
		cil: "application/vnd.ms-artgalry",
		cab: "application/vnd.ms-cab-compressed",
		xls: "application/vnd.ms-excel",
		xlm: "application/vnd.ms-excel",
		xla: "application/vnd.ms-excel",
		xlc: "application/vnd.ms-excel",
		xlt: "application/vnd.ms-excel",
		xlw: "application/vnd.ms-excel",
		xlam: "application/vnd.ms-excel.addin.macroenabled.12",
		xlsb: "application/vnd.ms-excel.sheet.binary.macroenabled.12",
		xlsm: "application/vnd.ms-excel.sheet.macroenabled.12",
		xltm: "application/vnd.ms-excel.template.macroenabled.12",
		eot: "application/vnd.ms-fontobject",
		chm: "application/vnd.ms-htmlhelp",
		ims: "application/vnd.ms-ims",
		lrm: "application/vnd.ms-lrm",
		thmx: "application/vnd.ms-officetheme",
		msg: "application/vnd.ms-outlook",
		cat: "application/vnd.ms-pki.seccat",
		stl: "model/stl",
		ppt: "application/vnd.ms-powerpoint",
		pps: "application/vnd.ms-powerpoint",
		pot: "application/vnd.ms-powerpoint",
		ppam: "application/vnd.ms-powerpoint.addin.macroenabled.12",
		pptm: "application/vnd.ms-powerpoint.presentation.macroenabled.12",
		sldm: "application/vnd.ms-powerpoint.slide.macroenabled.12",
		ppsm: "application/vnd.ms-powerpoint.slideshow.macroenabled.12",
		potm: "application/vnd.ms-powerpoint.template.macroenabled.12",
		mpp: "application/vnd.ms-project",
		mpt: "application/vnd.ms-project",
		docm: "application/vnd.ms-word.document.macroenabled.12",
		dotm: "application/vnd.ms-word.template.macroenabled.12",
		wps: "application/vnd.ms-works",
		wks: "application/vnd.ms-works",
		wcm: "application/vnd.ms-works",
		wdb: "application/vnd.ms-works",
		wpl: "application/vnd.ms-wpl",
		xps: "application/vnd.ms-xpsdocument",
		mseq: "application/vnd.mseq",
		mus: "application/vnd.musician",
		msty: "application/vnd.muvee.style",
		taglet: "application/vnd.mynfc",
		nlu: "application/vnd.neurolanguage.nlu",
		ntf: "application/vnd.nitf",
		nitf: "application/vnd.nitf",
		nnd: "application/vnd.noblenet-directory",
		nns: "application/vnd.noblenet-sealer",
		nnw: "application/vnd.noblenet-web",
		ngdat: "application/vnd.nokia.n-gage.data",
		"n-gage": "application/vnd.nokia.n-gage.symbian.install",
		rpst: "application/vnd.nokia.radio-preset",
		rpss: "application/vnd.nokia.radio-presets",
		edm: "application/vnd.novadigm.edm",
		edx: "application/vnd.novadigm.edx",
		ext: "application/vnd.novadigm.ext",
		odc: "application/vnd.oasis.opendocument.chart",
		otc: "application/vnd.oasis.opendocument.chart-template",
		odb: "application/vnd.oasis.opendocument.database",
		odf: "application/vnd.oasis.opendocument.formula",
		odft: "application/vnd.oasis.opendocument.formula-template",
		odg: "application/vnd.oasis.opendocument.graphics",
		otg: "application/vnd.oasis.opendocument.graphics-template",
		odi: "application/vnd.oasis.opendocument.image",
		oti: "application/vnd.oasis.opendocument.image-template",
		odp: "application/vnd.oasis.opendocument.presentation",
		otp: "application/vnd.oasis.opendocument.presentation-template",
		ods: "application/vnd.oasis.opendocument.spreadsheet",
		ots: "application/vnd.oasis.opendocument.spreadsheet-template",
		odt: "application/vnd.oasis.opendocument.text",
		odm: "application/vnd.oasis.opendocument.text-master",
		ott: "application/vnd.oasis.opendocument.text-template",
		oth: "application/vnd.oasis.opendocument.text-web",
		xo: "application/vnd.olpc-sugar",
		dd2: "application/vnd.oma.dd2+xml",
		obgx: "application/vnd.openblox.game+xml",
		oxt: "application/vnd.openofficeorg.extension",
		osm: "application/vnd.openstreetmap.data+xml",
		pptx: "application/vnd.openxmlformats-officedocument.presentationml.presentation",
		sldx: "application/vnd.openxmlformats-officedocument.presentationml.slide",
		ppsx: "application/vnd.openxmlformats-officedocument.presentationml.slideshow",
		potx: "application/vnd.openxmlformats-officedocument.presentationml.template",
		xlsx: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
		xltx: "application/vnd.openxmlformats-officedocument.spreadsheetml.template",
		docx: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
		dotx: "application/vnd.openxmlformats-officedocument.wordprocessingml.template",
		mgp: "application/vnd.osgeo.mapguide.package",
		dp: "application/vnd.osgi.dp",
		esa: "application/vnd.osgi.subsystem",
		pdb: "application/x-pilot",
		pqa: "application/vnd.palm",
		oprc: "application/vnd.palm",
		paw: "application/vnd.pawaafile",
		str: "application/vnd.pg.format",
		ei6: "application/vnd.pg.osasli",
		efif: "application/vnd.picsel",
		wg: "application/vnd.pmi.widget",
		plf: "application/vnd.pocketlearn",
		pbd: "application/vnd.powerbuilder6",
		box: "application/vnd.previewsystems.box",
		mgz: "application/vnd.proteus.magazine",
		qps: "application/vnd.publishare-delta-tree",
		ptid: "application/vnd.pvi.ptid1",
		qxd: "application/vnd.quark.quarkxpress",
		qxt: "application/vnd.quark.quarkxpress",
		qwd: "application/vnd.quark.quarkxpress",
		qwt: "application/vnd.quark.quarkxpress",
		qxl: "application/vnd.quark.quarkxpress",
		qxb: "application/vnd.quark.quarkxpress",
		bed: "application/vnd.realvnc.bed",
		mxl: "application/vnd.recordare.musicxml",
		musicxml: "application/vnd.recordare.musicxml+xml",
		cryptonote: "application/vnd.rig.cryptonote",
		cod: "application/vnd.rim.cod",
		rm: "application/vnd.rn-realmedia",
		rmvb: "application/vnd.rn-realmedia-vbr",
		link66: "application/vnd.route66.link66+xml",
		st: "application/vnd.sailingtracker.track",
		see: "application/vnd.seemail",
		sema: "application/vnd.sema",
		semd: "application/vnd.semd",
		semf: "application/vnd.semf",
		ifm: "application/vnd.shana.informed.formdata",
		itp: "application/vnd.shana.informed.formtemplate",
		iif: "application/vnd.shana.informed.interchange",
		ipk: "application/vnd.shana.informed.package",
		twd: "application/vnd.simtech-mindmapper",
		twds: "application/vnd.simtech-mindmapper",
		mmf: "application/vnd.smaf",
		teacher: "application/vnd.smart.teacher",
		fo: "application/vnd.software602.filler.form+xml",
		sdkm: "application/vnd.solent.sdkm+xml",
		sdkd: "application/vnd.solent.sdkm+xml",
		dxp: "application/vnd.spotfire.dxp",
		sfs: "application/vnd.spotfire.sfs",
		sdc: "application/vnd.stardivision.calc",
		sda: "application/vnd.stardivision.draw",
		sdd: "application/vnd.stardivision.impress",
		smf: "application/vnd.stardivision.math",
		sdw: "application/vnd.stardivision.writer",
		vor: "application/vnd.stardivision.writer",
		sgl: "application/vnd.stardivision.writer-global",
		smzip: "application/vnd.stepmania.package",
		sm: "application/vnd.stepmania.stepchart",
		wadl: "application/vnd.sun.wadl+xml",
		sxc: "application/vnd.sun.xml.calc",
		stc: "application/vnd.sun.xml.calc.template",
		sxd: "application/vnd.sun.xml.draw",
		std: "application/vnd.sun.xml.draw.template",
		sxi: "application/vnd.sun.xml.impress",
		sti: "application/vnd.sun.xml.impress.template",
		sxm: "application/vnd.sun.xml.math",
		sxw: "application/vnd.sun.xml.writer",
		sxg: "application/vnd.sun.xml.writer.global",
		stw: "application/vnd.sun.xml.writer.template",
		sus: "application/vnd.sus-calendar",
		susp: "application/vnd.sus-calendar",
		svd: "application/vnd.svd",
		sis: "application/vnd.symbian.install",
		sisx: "application/vnd.symbian.install",
		xsm: "application/vnd.syncml+xml",
		bdm: "application/vnd.syncml.dm+wbxml",
		xdm: "application/vnd.syncml.dm+xml",
		ddf: "application/vnd.syncml.dmddf+xml",
		tao: "application/vnd.tao.intent-module-archive",
		pcap: "application/vnd.tcpdump.pcap",
		cap: "application/vnd.tcpdump.pcap",
		dmp: "application/vnd.tcpdump.pcap",
		tmo: "application/vnd.tmobile-livetv",
		tpt: "application/vnd.trid.tpt",
		mxs: "application/vnd.triscape.mxs",
		tra: "application/vnd.trueapp",
		ufd: "application/vnd.ufdl",
		ufdl: "application/vnd.ufdl",
		utz: "application/vnd.uiq.theme",
		umj: "application/vnd.umajin",
		unityweb: "application/vnd.unity",
		uoml: "application/vnd.uoml+xml",
		vcx: "application/vnd.vcx",
		vsd: "application/vnd.visio",
		vst: "application/vnd.visio",
		vss: "application/vnd.visio",
		vsw: "application/vnd.visio",
		vis: "application/vnd.visionary",
		vsf: "application/vnd.vsf",
		wbxml: "application/vnd.wap.wbxml",
		wmlc: "application/vnd.wap.wmlc",
		wmlsc: "application/vnd.wap.wmlscriptc",
		wtb: "application/vnd.webturbo",
		nbp: "application/vnd.wolfram.player",
		wpd: "application/vnd.wordperfect",
		wqd: "application/vnd.wqd",
		stf: "application/vnd.wt.stf",
		xar: "application/vnd.xara",
		xfdl: "application/vnd.xfdl",
		hvd: "application/vnd.yamaha.hv-dic",
		hvs: "application/vnd.yamaha.hv-script",
		hvp: "application/vnd.yamaha.hv-voice",
		osf: "application/vnd.yamaha.openscoreformat",
		osfpvg: "application/vnd.yamaha.openscoreformat.osfpvg+xml",
		saf: "application/vnd.yamaha.smaf-audio",
		spf: "application/vnd.yamaha.smaf-phrase",
		cmp: "application/vnd.yellowriver-custom-menu",
		zir: "application/vnd.zul",
		zirz: "application/vnd.zul",
		zaz: "application/vnd.zzazz.deck+xml",
		vxml: "application/voicexml+xml",
		wasm: "application/wasm",
		wgt: "application/widget",
		hlp: "application/winhlp",
		wsdl: "application/wsdl+xml",
		wspolicy: "application/wspolicy+xml",
		"7z": "application/x-7z-compressed",
		abw: "application/x-abiword",
		ace: "application/x-ace-compressed",
		arj: "application/x-arj",
		aab: "application/x-authorware-bin",
		x32: "application/x-authorware-bin",
		u32: "application/x-authorware-bin",
		vox: "application/x-authorware-bin",
		aam: "application/x-authorware-map",
		aas: "application/x-authorware-seg",
		bcpio: "application/x-bcpio",
		torrent: "application/x-bittorrent",
		blb: "application/x-blorb",
		blorb: "application/x-blorb",
		bz: "application/x-bzip",
		bz2: "application/x-bzip2",
		boz: "application/x-bzip2",
		cbr: "application/x-cbr",
		cba: "application/x-cbr",
		cbt: "application/x-cbr",
		cbz: "application/x-cbr",
		cb7: "application/x-cbr",
		vcd: "application/x-cdlink",
		cfs: "application/x-cfs-compressed",
		chat: "application/x-chat",
		pgn: "application/x-chess-pgn",
		crx: "application/x-chrome-extension",
		cco: "application/x-cocoa",
		nsc: "application/x-conference",
		cpio: "application/x-cpio",
		csh: "application/x-csh",
		udeb: "application/x-debian-package",
		dgc: "application/x-dgc-compressed",
		dir: "application/x-director",
		dcr: "application/x-director",
		dxr: "application/x-director",
		cst: "application/x-director",
		cct: "application/x-director",
		cxt: "application/x-director",
		w3d: "application/x-director",
		fgd: "application/x-director",
		swa: "application/x-director",
		wad: "application/x-doom",
		ncx: "application/x-dtbncx+xml",
		dtb: "application/x-dtbook+xml",
		res: "application/x-dtbresource+xml",
		dvi: "application/x-dvi",
		evy: "application/x-envoy",
		eva: "application/x-eva",
		bdf: "application/x-font-bdf",
		gsf: "application/x-font-ghostscript",
		psf: "application/x-font-linux-psf",
		pcf: "application/x-font-pcf",
		snf: "application/x-font-snf",
		pfa: "application/x-font-type1",
		pfb: "application/x-font-type1",
		pfm: "application/x-font-type1",
		afm: "application/x-font-type1",
		arc: "application/x-freearc",
		spl: "application/x-futuresplash",
		gca: "application/x-gca-compressed",
		ulx: "application/x-glulx",
		gnumeric: "application/x-gnumeric",
		gramps: "application/x-gramps-xml",
		gtar: "application/x-gtar",
		hdf: "application/x-hdf",
		php: "application/x-httpd-php",
		install: "application/x-install-instructions",
		jardiff: "application/x-java-archive-diff",
		jnlp: "application/x-java-jnlp-file",
		kdbx: "application/x-keepass2",
		latex: "application/x-latex",
		luac: "application/x-lua-bytecode",
		lzh: "application/x-lzh-compressed",
		lha: "application/x-lzh-compressed",
		run: "application/x-makeself",
		mie: "application/x-mie",
		prc: "application/x-pilot",
		mobi: "application/x-mobipocket-ebook",
		application: "application/x-ms-application",
		lnk: "application/x-ms-shortcut",
		wmd: "application/x-ms-wmd",
		wmz: "application/x-msmetafile",
		xbap: "application/x-ms-xbap",
		mdb: "application/x-msaccess",
		obd: "application/x-msbinder",
		crd: "application/x-mscardfile",
		clp: "application/x-msclip",
		com: "application/x-msdownload",
		bat: "application/x-msdownload",
		mvb: "application/x-msmediaview",
		m13: "application/x-msmediaview",
		m14: "application/x-msmediaview",
		wmf: "image/wmf",
		emf: "image/emf",
		emz: "application/x-msmetafile",
		mny: "application/x-msmoney",
		pub: "application/x-mspublisher",
		scd: "application/x-msschedule",
		trm: "application/x-msterminal",
		wri: "application/x-mswrite",
		nc: "application/x-netcdf",
		cdf: "application/x-netcdf",
		pac: "application/x-ns-proxy-autoconfig",
		nzb: "application/x-nzb",
		pl: "application/x-perl",
		pm: "application/x-perl",
		p12: "application/x-pkcs12",
		pfx: "application/x-pkcs12",
		p7b: "application/x-pkcs7-certificates",
		spc: "application/x-pkcs7-certificates",
		p7r: "application/x-pkcs7-certreqresp",
		rar: "application/x-rar-compressed",
		rpm: "application/x-redhat-package-manager",
		ris: "application/x-research-info-systems",
		sea: "application/x-sea",
		sh: "application/x-sh",
		shar: "application/x-shar",
		swf: "application/x-shockwave-flash",
		xap: "application/x-silverlight-app",
		sql: "application/x-sql",
		sit: "application/x-stuffit",
		sitx: "application/x-stuffitx",
		srt: "application/x-subrip",
		sv4cpio: "application/x-sv4cpio",
		sv4crc: "application/x-sv4crc",
		t3: "application/x-t3vm-image",
		gam: "application/x-tads",
		tar: "application/x-tar",
		tcl: "application/x-tcl",
		tk: "application/x-tcl",
		tex: "application/x-tex",
		tfm: "application/x-tex-tfm",
		texinfo: "application/x-texinfo",
		texi: "application/x-texinfo",
		obj: "model/obj",
		ustar: "application/x-ustar",
		hdd: "application/x-virtualbox-hdd",
		ova: "application/x-virtualbox-ova",
		ovf: "application/x-virtualbox-ovf",
		vbox: "application/x-virtualbox-vbox",
		"vbox-extpack": "application/x-virtualbox-vbox-extpack",
		vdi: "application/x-virtualbox-vdi",
		vhd: "application/x-virtualbox-vhd",
		vmdk: "application/x-virtualbox-vmdk",
		src: "application/x-wais-source",
		webapp: "application/x-web-app-manifest+json",
		der: "application/x-x509-ca-cert",
		crt: "application/x-x509-ca-cert",
		pem: "application/x-x509-ca-cert",
		fig: "application/x-xfig",
		xlf: "application/xliff+xml",
		xpi: "application/x-xpinstall",
		xz: "application/x-xz",
		z1: "application/x-zmachine",
		z2: "application/x-zmachine",
		z3: "application/x-zmachine",
		z4: "application/x-zmachine",
		z5: "application/x-zmachine",
		z6: "application/x-zmachine",
		z7: "application/x-zmachine",
		z8: "application/x-zmachine",
		xaml: "application/xaml+xml",
		xav: "application/xcap-att+xml",
		xca: "application/xcap-caps+xml",
		xel: "application/xcap-el+xml",
		xns: "application/xcap-ns+xml",
		xenc: "application/xenc+xml",
		xhtml: "application/xhtml+xml",
		xht: "application/xhtml+xml",
		xml: "text/xml",
		config: "text/xml",
		xsl: "application/xml",
		xsd: "application/xml",
		rng: "application/xml",
		dtd: "application/xml-dtd",
		xop: "application/xop+xml",
		xpl: "application/xproc+xml",
		xslt: "application/xslt+xml",
		xspf: "application/xspf+xml",
		mxml: "application/xv+xml",
		xhvml: "application/xv+xml",
		xvml: "application/xv+xml",
		xvm: "application/xv+xml",
		yang: "application/yang",
		yin: "application/yin+xml",
		zip: "application/zip",
		"3gpp": "video/3gpp",
		adp: "audio/adpcm",
		au: "audio/basic",
		snd: "audio/basic",
		mid: "audio/midi",
		midi: "audio/midi",
		kar: "audio/midi",
		rmi: "audio/midi",
		mxmf: "audio/mobile-xmf",
		mp3: "audio/mpeg",
		m4a: "audio/x-m4a",
		mp4a: "audio/mp4",
		mpga: "audio/mpeg",
		mp2: "audio/mpeg",
		mp2a: "audio/mpeg",
		m2a: "audio/mpeg",
		m3a: "audio/mpeg",
		oga: "audio/ogg",
		ogg: "audio/ogg",
		spx: "audio/ogg",
		s3m: "audio/s3m",
		sil: "audio/silk",
		uva: "audio/vnd.dece.audio",
		uvva: "audio/vnd.dece.audio",
		eol: "audio/vnd.digital-winds",
		dra: "audio/vnd.dra",
		dts: "audio/vnd.dts",
		dtshd: "audio/vnd.dts.hd",
		lvp: "audio/vnd.lucent.voice",
		pya: "audio/vnd.ms-playready.media.pya",
		ecelp4800: "audio/vnd.nuera.ecelp4800",
		ecelp7470: "audio/vnd.nuera.ecelp7470",
		ecelp9600: "audio/vnd.nuera.ecelp9600",
		rip: "audio/vnd.rip",
		wav: "audio/x-wav",
		weba: "audio/webm",
		aac: "audio/x-aac",
		aif: "audio/x-aiff",
		aiff: "audio/x-aiff",
		aifc: "audio/x-aiff",
		caf: "audio/x-caf",
		flac: "audio/flac",
		mka: "audio/x-matroska",
		m3u: "audio/x-mpegurl",
		wax: "audio/x-ms-wax",
		wma: "audio/x-ms-wma",
		ram: "audio/x-pn-realaudio",
		ra: "audio/x-realaudio",
		rmp: "audio/x-pn-realaudio-plugin",
		xm: "audio/xm",
		cdx: "chemical/x-cdx",
		cif: "chemical/x-cif",
		cmdf: "chemical/x-cmdf",
		cml: "chemical/x-cml",
		csml: "chemical/x-csml",
		xyz: "chemical/x-xyz",
		ttc: "font/collection",
		otf: "font/otf",
		ttf: "font/ttf",
		woff: "font/woff",
		woff2: "font/woff2",
		exr: "image/aces",
		apng: "image/apng",
		avif: "image/avif",
		bmp: "image/x-ms-bmp",
		cgm: "image/cgm",
		drle: "image/dicom-rle",
		fits: "image/fits",
		g3: "image/g3fax",
		gif: "image/gif",
		heic: "image/heic",
		heics: "image/heic-sequence",
		heif: "image/heif",
		heifs: "image/heif-sequence",
		hej2: "image/hej2k",
		hsj2: "image/hsj2",
		ief: "image/ief",
		jls: "image/jls",
		jp2: "image/jp2",
		jpg2: "image/jp2",
		jpeg: "image/jpeg",
		jpg: "image/jpeg",
		jpe: "image/jpeg",
		jph: "image/jph",
		jhc: "image/jphc",
		jpm: "video/jpm",
		jpx: "image/jpx",
		jpf: "image/jpx",
		jxr: "image/jxr",
		jxra: "image/jxra",
		jxrs: "image/jxrs",
		jxs: "image/jxs",
		jxsc: "image/jxsc",
		jxsi: "image/jxsi",
		jxss: "image/jxss",
		ktx: "image/ktx",
		png: "image/png",
		btif: "image/prs.btif",
		pti: "image/prs.pti",
		sgi: "image/sgi",
		svg: "image/svg+xml",
		svgz: "image/svg+xml",
		t38: "image/t38",
		tif: "image/tiff",
		tiff: "image/tiff",
		tfx: "image/tiff-fx",
		psd: "image/vnd.adobe.photoshop",
		azv: "image/vnd.airzip.accelerator.azv",
		uvi: "image/vnd.dece.graphic",
		uvvi: "image/vnd.dece.graphic",
		uvg: "image/vnd.dece.graphic",
		uvvg: "image/vnd.dece.graphic",
		djvu: "image/vnd.djvu",
		djv: "image/vnd.djvu",
		sub: "text/vnd.dvb.subtitle",
		dwg: "image/vnd.dwg",
		dxf: "image/vnd.dxf",
		fbs: "image/vnd.fastbidsheet",
		fpx: "image/vnd.fpx",
		fst: "image/vnd.fst",
		mmr: "image/vnd.fujixerox.edmics-mmr",
		rlc: "image/vnd.fujixerox.edmics-rlc",
		ico: "image/x-icon",
		dds: "image/vnd.ms-dds",
		mdi: "image/vnd.ms-modi",
		wdp: "image/vnd.ms-photo",
		npx: "image/vnd.net-fpx",
		tap: "image/vnd.tencent.tap",
		vtf: "image/vnd.valve.source.texture",
		wbmp: "image/vnd.wap.wbmp",
		xif: "image/vnd.xiff",
		pcx: "image/x-pcx",
		webp: "image/webp",
		"3ds": "image/x-3ds",
		ras: "image/x-cmu-raster",
		cmx: "image/x-cmx",
		fh: "image/x-freehand",
		fhc: "image/x-freehand",
		fh4: "image/x-freehand",
		fh5: "image/x-freehand",
		fh7: "image/x-freehand",
		jng: "image/x-jng",
		sid: "image/x-mrsid-image",
		pic: "image/x-pict",
		pct: "image/x-pict",
		pnm: "image/x-portable-anymap",
		pbm: "image/x-portable-bitmap",
		pgm: "image/x-portable-graymap",
		ppm: "image/x-portable-pixmap",
		rgb: "image/x-rgb",
		tga: "image/x-tga",
		xbm: "image/x-xbitmap",
		xpm: "image/x-xpixmap",
		xwd: "image/x-xwindowdump",
		"disposition-notification": "message/disposition-notification",
		u8msg: "message/global",
		u8dsn: "message/global-delivery-status",
		u8mdn: "message/global-disposition-notification",
		u8hdr: "message/global-headers",
		eml: "message/rfc822",
		mime: "message/rfc822",
		wsc: "message/vnd.wfa.wsc",
		"3mf": "model/3mf",
		gltf: "model/gltf+json",
		glb: "model/gltf-binary",
		igs: "model/iges",
		iges: "model/iges",
		msh: "model/mesh",
		mesh: "model/mesh",
		silo: "model/mesh",
		mtl: "model/mtl",
		dae: "model/vnd.collada+xml",
		dwf: "model/vnd.dwf",
		gdl: "model/vnd.gdl",
		gtw: "model/vnd.gtw",
		mts: "model/vnd.mts",
		ogex: "model/vnd.opengex",
		x_b: "model/vnd.parasolid.transmit.binary",
		x_t: "model/vnd.parasolid.transmit.text",
		usdz: "model/vnd.usdz+zip",
		bsp: "model/vnd.valve.source.compiled-map",
		vtu: "model/vnd.vtu",
		wrl: "model/vrml",
		vrml: "model/vrml",
		x3db: "model/x3d+fastinfoset",
		x3dbz: "model/x3d+binary",
		x3dv: "model/x3d-vrml",
		x3dvz: "model/x3d+vrml",
		x3d: "model/x3d+xml",
		x3dz: "model/x3d+xml",
		appcache: "text/cache-manifest",
		manifest: "text/cache-manifest",
		ics: "text/calendar",
		ifb: "text/calendar",
		coffee: "text/coffeescript",
		litcoffee: "text/coffeescript",
		css: "text/css",
		csv: "text/csv",
		html: "text/html",
		htm: "text/html",
		shtml: "text/html",
		jade: "text/jade",
		jsx: "text/jsx",
		less: "text/less",
		markdown: "text/markdown",
		md: "text/markdown",
		mml: "text/mathml",
		mdx: "text/mdx",
		n3: "text/n3",
		txt: "text/plain",
		text: "text/plain",
		conf: "text/plain",
		def: "text/plain",
		list: "text/plain",
		log: "text/plain",
		in: "text/plain",
		ini: "text/plain",
		url: "text/plain",
		cfg: "text/plain",
		dsc: "text/prs.lines.tag",
		rtx: "text/richtext",
		sgml: "text/sgml",
		sgm: "text/sgml",
		shex: "text/shex",
		slim: "text/slim",
		slm: "text/slim",
		stylus: "text/stylus",
		styl: "text/stylus",
		tsv: "text/tab-separated-values",
		t: "text/troff",
		tr: "text/troff",
		roff: "text/troff",
		man: "text/troff",
		me: "text/troff",
		ms: "text/troff",
		ttl: "text/turtle",
		uri: "text/uri-list",
		uris: "text/uri-list",
		urls: "text/uri-list",
		vcard: "text/vcard",
		curl: "text/vnd.curl",
		dcurl: "text/vnd.curl.dcurl",
		mcurl: "text/vnd.curl.mcurl",
		scurl: "text/vnd.curl.scurl",
		fly: "text/vnd.fly",
		flx: "text/vnd.fmi.flexstor",
		gv: "text/vnd.graphviz",
		"3dml": "text/vnd.in3d.3dml",
		spot: "text/vnd.in3d.spot",
		jad: "text/vnd.sun.j2me.app-descriptor",
		wml: "text/vnd.wap.wml",
		wmls: "text/vnd.wap.wmlscript",
		vtt: "text/vtt",
		s: "text/x-asm",
		asm: "text/x-asm",
		c: "text/x-c",
		cc: "text/x-c",
		cxx: "text/x-c",
		cpp: "text/x-c",
		h: "text/x-c",
		hh: "text/x-c",
		dic: "text/x-c",
		htc: "text/x-component",
		f: "text/x-fortran",
		for: "text/x-fortran",
		f77: "text/x-fortran",
		f90: "text/x-fortran",
		hbs: "text/x-handlebars-template",
		java: "text/x-java-source",
		lua: "text/x-lua",
		mkd: "text/x-markdown",
		nfo: "text/x-nfo",
		opml: "text/x-opml",
		p: "text/x-pascal",
		pas: "text/x-pascal",
		pde: "text/x-processing",
		sass: "text/x-sass",
		scss: "text/x-scss",
		etx: "text/x-setext",
		sfv: "text/x-sfv",
		ymp: "text/x-suse-ymp",
		uu: "text/x-uuencode",
		vcs: "text/x-vcalendar",
		vcf: "text/x-vcard",
		yaml: "text/yaml",
		yml: "text/yaml",
		"3gp": "video/3gpp",
		"3g2": "video/3gpp2",
		h261: "video/h261",
		h263: "video/h263",
		h264: "video/h264",
		jpgv: "video/jpeg",
		jpgm: "video/jpm",
		mj2: "video/mj2",
		mjp2: "video/mj2",
		ts: "video/mp2t",
		mp4: "video/mp4",
		mp4v: "video/mp4",
		mpg4: "video/mp4",
		mpeg: "video/mpeg",
		mpg: "video/mpeg",
		mpe: "video/mpeg",
		m1v: "video/mpeg",
		m2v: "video/mpeg",
		ogv: "video/ogg",
		qt: "video/quicktime",
		mov: "video/quicktime",
		uvh: "video/vnd.dece.hd",
		uvvh: "video/vnd.dece.hd",
		uvm: "video/vnd.dece.mobile",
		uvvm: "video/vnd.dece.mobile",
		uvp: "video/vnd.dece.pd",
		uvvp: "video/vnd.dece.pd",
		uvs: "video/vnd.dece.sd",
		uvvs: "video/vnd.dece.sd",
		uvv: "video/vnd.dece.video",
		uvvv: "video/vnd.dece.video",
		dvb: "video/vnd.dvb.file",
		fvt: "video/vnd.fvt",
		mxu: "video/vnd.mpegurl",
		m4u: "video/vnd.mpegurl",
		pyv: "video/vnd.ms-playready.media.pyv",
		uvu: "video/vnd.uvvu.mp4",
		uvvu: "video/vnd.uvvu.mp4",
		viv: "video/vnd.vivo",
		webm: "video/webm",
		f4v: "video/x-f4v",
		fli: "video/x-fli",
		flv: "video/x-flv",
		m4v: "video/x-m4v",
		mkv: "video/x-matroska",
		mk3d: "video/x-matroska",
		mks: "video/x-matroska",
		mng: "video/x-mng",
		asf: "video/x-ms-asf",
		asx: "video/x-ms-asf",
		vob: "video/x-ms-vob",
		wm: "video/x-ms-wm",
		wmv: "video/x-ms-wmv",
		wmx: "video/x-ms-wmx",
		wvx: "video/x-ms-wvx",
		avi: "video/x-msvideo",
		movie: "video/x-sgi-movie",
		smv: "video/x-smv",
		ice: "x-conference/x-cooltalk"
	};
	(() => {
		function e() {
			return "dark" === _c.theme ? "dark" : (S.codemirror_theme || (S.codemirror_theme = j.get("files:codemirror_theme") || "light"), S.codemirror_theme)
		}

		let t, i = 0, a = 0;

		function s() {
			D.preview.dataset.counter = S.index + 1 + "/" + Q.list.matchingItems.length
		}

		function l() {
			var e = D.preview.firstElementChild;
			e && ["audio", "video"].includes(S.type) && ["AUDIO", "VIDEO"].includes(e.nodeName) && !e.paused && e.pause()
		}

		function p() {
			if (S.codemirror_saving || !D.code_save_button || D.code_save_button.disabled) return;
			if (_c.demo_mode) return F.demo();
			if (!te) return F.license();
			if (!S.item.is_writeable) return F.toggle(!1, `${J.get("file", !0)} ${J.get("is not writeable")}`);
			S.codemirror_saving = !0, D.code_save_button.disabled = !0;
			const e = S.item;
			new se({
				action: "text_edit", action_name: "save", items: [S.item], text: S.codemirror.getValue(), parent_path: _c.current_path, parent_dir: _c.current_dir, complete: t => {
					e === S.item && (S.codemirror_saving = !1, D.code_save_button.disabled = !1)
				}
			})
		}

		function u(e, t) {
			_c.history && history[e + "State"](null, S.item.basename, "#" + encodeURIComponent(S.item.basename))
		}

		function x(e) {
			anime({targets: D.preview.querySelector("svg").children, scale: [.9, 1], opacity: [0, 1], duration: 120, easing: "easeOutQuad", delay: anime.stagger(30, {start: e, direction: "reverse"})})
		}

		const y = e => {
			let t = Q.list.matchingItems.length, i = S.index + e;
			return i < 0 ? t - 1 : i >= t ? 0 : i
		};

		function A(e) {
			var t = Q.list.matchingItems;
			if (!(t.length < 2)) {
				if (S.index = y(e), s(), D.preview.classList.add("modal-count-show"), i && clearTimeout(a), a = setTimeout((() => i = 0), 500), i) return N(t[S.index]._values);
				i = 1, l(), N(t[S.index]._values), ["file", "dir"].includes(S.type) && x(0)
			}
		}

		function L() {
			S.codemirror_xhr && (S.codemirror_xhr.abort(), S.codemirror_xhr = !1)
		}

		function H() {
			return location.hash === "#" + encodeURIComponent(S.item.basename)
		}

		function k(e) {
			document.documentElement.classList.toggle("modal-open", !!e), D.modal.classList.toggle("modal-show", !!e)
		}

		function M() {
			D.popup.classList.toggle("modal-popup-fullscreen"), S.codemirror && S.codemirror.refresh()
		}

		var z, E = ["start-start", "center-start", "end-start", "start-center", "center-center", "end-center", "start-end", "center-end", "end-end"], $ = (z = j.get("files:modal:position")) && E.includes(z) ? z : "center-center";

		function O(e, t) {
			var i = (e || $).split("-"), a = ["x", "y"].map(((e, t) => `modal-pos-${e}-${i[t]}`));
			return t ? D.popup.classList[t](...a) : a.join(" ")
		}

		const S = Q.modal = {};
		document.body.insertAdjacentHTML("beforeend", `\n\t<div class="modal" data-action="close-bg" style="display:none;">\n\t\t<div class="modal-popup">\n\t\t\t<div class="modal-header">\n\t\t\t\t<h2 class="modal-title"></h2>\n\t\t\t\t${_c.allow_text_edit ? `<button type="button" class="button-icon modal-code-button" data-action="save" data-lang="save" data-tooltip="${J.get("save")}">${U.get_svg_icon("save_edit")}</button>` : ""}\n\t\t\t\t<button type="button" class="button-icon modal-code-button" data-action="copy" data-lang="copy text" data-tooltip="${J.get("copy text")}">${U.get_svg_icon("clipboard")}</button>\n\t\t\t\t<button type="button" class="button-icon modal-code-button" data-action="toggle-codemirror-theme">${U.get_svg_icon_multi("theme_light", "theme_dark")}</button>\n\t\t\t\t<button type="button" class="button-icon modal-code-button" data-action="fullscreen">${U.get_svg_icon_multi("expand", "collapse")}</button>\n\t\t\t\t${_(!0)}\n\t\t\t\t<span class="modal-pos">${V(E, (e => '<span class="modal-pos-el' + (e === $ ? " modal-pos-active" : "") + '" data-action="' + e + '"></span>'))}</span>\n\t\t\t\t<button type="button" class="button-icon" data-action="close">${U.get_svg_icon("close_thin")}</button>\n\t\t\t</div>\n\t\t\t<button class="button-icon modal-nav-left" data-action="nav-left">${U.get_svg_icon("arrow_left")}</button>\n\t\t\t<button class="button-icon modal-nav-right" data-action="nav-right">${U.get_svg_icon("arrow_right")}</button>\n\t\t\t<div class="modal-preview" id="modal_preview"></div>\n\t\t\t<div class="modal-info"></div>\n\t\t</div>\n\t</div>`);
		const D = S.el = {modal: document.body.lastElementChild};

		function N(e) {
			L(), B(e), u("replace")
		}

		function B(t) {
			var i;
			if (D.modal.scrollTop = 0, S.codemirror && D.header.classList.remove("modal-header-code"), D.code_save_button && D.code_save_button.disabled && (D.code_save_button.disabled = !1), Object.assign(S, {
				item: t,
				codemirror: !1,
				codemirror_xhr: !1,
				codemirror_saving: !1,
				type: t.is_dir ? "dir" : "file"
			}), D.title.innerText = D.title.title = t.display_name || t.basename || "", !t.is_dir && t.is_readable) if (t.browser_image) S.type = "image", i = '<img data-action="zoom" src="' + r(t) + '" class="modal-image files-img-placeholder' + ("ico" == t.ext ? " modal-image-ico" : "") + '"' + (!t.dimensions || !_c.server_exif && Y.image_orientation || !Y.image_orientation && T(t.image) ? "" : ' width="' + t.dimensions[0] + '" height="' + t.dimensions[1] + '" style="--ratio:' + t.ratio + '"') + "></img>"; else if (t.is_browser_video) S.type = "video", i = `<video src="${r(t)}" type="${t.mime}" class="modal-video" controls playsinline disablepictureinpicture controlslist="nodownload" autoplay loop></video>`; else if (_c.video_thumbs_enabled && "video" === t.mime0 && t.is_readable) S.type = "video-thumb", i = `<img src="${_c.script}?action=file&file=${encodeURIComponent(t.path)}&resize=video&${_c.image_cache_hash}.${t.mtime}.${t.filesize}" class="modal-image modal-image-video files-img-placeholder" width="${t.preview_dimensions[0]}" height="${t.preview_dimensions[1]}" style="--ratio:${t.preview_ratio}"></img>`; else if (G("audio", t)) S.type = "audio", i = '<audio src="' + r(t) + '" type="' + t.mime + '" class="modal-audio" controls playsinline controlslist="nodownload"></audio>'; else if (t.embed) S.type = "embed", i = '<iframe class="modal-embed" width="560" height="315" src="' + t.embed + '" frameborder="0" allow="accelerometer; fullscreen; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><div class="modal-preview-spinner"></div>'; else {
				if (!t.hasOwnProperty("code_mode")) {
					var a = function (e) {
						if (e && !(e.filesize > _c.code_max_load)) {
							if (e.ext && "htaccess" === e.ext) return CodeMirror.findModeByName("nginx");
							if (e.ext && "csv" === e.ext) return CodeMirror.findModeByName("Spreadsheet");
							var t = !!e.mime && CodeMirror.findModeByMIME(e.mime);
							return t && "null" !== t.mode || !e.ext || (t = CodeMirror.findModeByExtension(e.ext) || t), t
						}
					}(t);
					t.code_mode = a && a.mode || !1
				}
				t.code_mode && (S.type = "code", U.load_plugin("codemirror"), i = '<div class="modal-preview-spinner"></div>')
			}
			i || (i = U.get_svg_large(t, "modal-svg") + R(t)), P(D.popup, `modal-popup modal-popup-${S.type} modal-${S.has_nav ? "multi" : "single"} ${O()} modal-codemirror-theme-${e()}`), Y.is_pointer && S.has_nav && (D.ArrowLeft.title = Q.list.matchingItems[y(-1)]._values.basename, D.ArrowRight.title = Q.list.matchingItems[y(1)]._values.basename);
			let s = t.is_dir ? "--svg-folder-fg" : `--type-${U.get_icon(t) || "default"}`, l = !!CSS.supports("background-color", "hslX(50 50% 50% / 50%)") && getComputedStyle(document.documentElement).getPropertyValue(s);
			D.popup.style = `--type-color:var(${s})${l && 0 === l.indexOf("hsl(") ? ";--type-color-hsl:" + l.split(")")[0].split("(")[1].split(",").join("") : ""}`, P(D.preview, "modal-preview modal-preview-" + S.type), D.preview.innerHTML = ["image", "file"].includes(S.type) || "dir" === S.type && t.url_path ? `<a href="${c(t)}" class="modal-preview-a" target="_blank"${t.browser_image ? ' data-action="zoom"' : ""} title="${J.get(t.browser_image ? "zoom" : "open in new tab")}" tabindex="-1">${i}</a>` : i, ["image", "video-thumb"].includes(S.type) && _class("files-img-placeholder", D.preview)[0].addEventListener("load", (e => e.target.classList.remove("files-img-placeholder"))), t.embed && D.preview.firstElementChild.addEventListener("load", (() => {
				D.preview.lastElementChild.remove()
			}), !0), t.code_mode && (S.codemirror_xhr = I({
				params: `file=${encodeURIComponent(t.path)}`, url: `${_c.script}?action=load_text_file`, always: () => {
					S.open && t === S.item && (S.codemirror_xhr = !1)
				}, fail: e => {
					e.status && S.open && t === S.item && (F.toggle(!1, (e.status ? e.status + " - " : "") + (e.statusText || t.basename)), D.preview.firstElementChild.remove())
				}, complete: i => {
					S.open && t === S.item && U.load_plugin("codemirror", (() => {
						S.open && t === S.item && (D.preview.firstElementChild.remove(), D.header.classList.add("modal-header-code"), S.codemirror = CodeMirror(D.preview, {
							value: i,
							lineWrapping: !0,
							lineNumbers: !0,
							readOnly: !_c.allow_text_edit,
							mode: t.code_mode,
							viewportMargin: 1 / 0,
							theme: "one-" + e(),
							addModeClass: "css" === t.code_mode,
							styleActiveLine: !0,
							extraKeys: Object.assign({F11: M}, _c.allow_text_edit ? {"Ctrl-S": p, "Cmd-S": p} : {})
						}), CodeMirror.autoLoadMode(S.codemirror, t.code_mode))
					}))
				}
			})), D.info.innerHTML = `\n\t\t\t<div class="modal-info-name">\n\t\t\t\t${t.url ? '<a href="' + c(t) + '" target="_blank">' : ""}\t\t\t\t${n(t.display_name || t.basename)}\n\t\t\t\t${t.url ? "</a>" : ""}\n\t\t\t</div>\t\t\t<div class="modal-info-meta">\n\t\t\t\t${t.mime ? '<span class="modal-info-mime" title="' + t.mime + '">' + U.get_svg_icon_files(t) + o(t.mime, "modal-info-mime-text") + "</span>" : ""}${h(t.dimensions, "modal-info-dimensions")}${f(t, "modal-info-filesize")}${function (e, t) {
				var i = e.is_readable && e.is_writeable;
				return e.fileperms ? '<span class="' + t + (i ? " is-readwrite" : " not-readwrite") + '">' + U.get_svg_icon(i ? "lock_open_outline" : "lock_outline") + e.fileperms + "</span>" : ""
			}(t, "modal-info-permissions")}\n\t\t\t</div>\n\t\t\t<div class="modal-info-date">${U.get_svg_icon("date")}${U.get_time(t, "llll", "LLLL", !0)}</div>\n\t\t\t${v(t.image, "modal-info-exif")}\n\t\t\t${g(t.image, "modal-info", !0)}\n\t\t`
		}

		function W(e) {
			e && e.target !== D.popup || (D.popup.removeEventListener("transitionend", W), S.open || (D.modal.style.display = "none", d(D.preview)))
		}

		function X() {
			S.open && !H() && U.close_modal(!1)
		}

		function K() {
			return !S.open || Swal.isVisible() || !H()
		}

		function ee(e) {
			return Q.list.matchingItems.length > 1 && ["ArrowLeft", "ArrowRight"].includes(e) && (!document.activeElement || !["AUDIO", "VIDEO", "TEXTAREA"].includes(document.activeElement.nodeName))
		}

		function ie(e) {
			if (!e.repeat && !K()) if ("Escape" === e.key) {
				if ("code" === S.type && ("TEXTAREA" === document.activeElement.nodeName || D.popup.classList.contains("modal-popup-fullscreen"))) return M();
				U.close_modal()
			} else "Enter" !== e.key || D.popup.contains(document.activeElement) ? ee(e.key) && (D[e.key].classList.add("modal-nav-active"), A("ArrowLeft" === e.key ? -1 : 1), D.preview.classList.add("modal-count-show")) : U.close_modal()
		}

		function ae(e) {
			!K() && ee(e.key) && (D[e.key].classList.remove("modal-nav-active"), D.preview.classList.remove("modal-count-show"))
		}

		function ne(e) {
			K() || D.popup.contains(e.target) || Array.from(D.header.children).find((e => "BUTTON" == e.nodeName && e.offsetParent)).focus()
		}

		function oe(e) {
			var t = (e ? "add" : "remove") + "EventListener";
			window[t]("popstate", X), document[t]("keydown", ie), document[t]("keyup", ae), document.body[t]("focus", ne, {capture: !0})
		}

		D.popup = D.modal.firstElementChild, D.header = D.popup.firstElementChild, D.ArrowLeft = D.popup.children[1], D.ArrowRight = D.popup.children[2], D.title = D.header.firstElementChild, D.code_save_button = !!_c.allow_text_edit && _query('[data-action="save"]', D.header), D.close = D.header.lastElementChild, D.preview = D.popup.children[3], D.info = D.popup.lastElementChild, D.pos_active = _class("modal-pos-active", D.header)[0], Y.is_touch && C(D.preview, (e => {
			if ("mouse" !== e.pointerType) {
				var t = e.target.closest(".modal-preview-a");
				t && !t.dataset.action && e.preventDefault()
			}
		})), ["down", "up"].forEach((e => D.modal.addEventListener("mouse" + e, (t => S["bg" + e] = t.target === D.modal)))), m(D.modal, ((e, t) => {
			if (!S.open) return t.preventDefault();
			if ("nav-left" === e) A(-1); else if ("nav-right" === e) A(1); else if ("context" === e) U.create_contextmenu(t, "modal", t.target, S.item); else if ("close-bg" === e) S.bgdown && S.bgup && U.close_modal(); else if ("close" === e) U.close_modal(); else if ("zoom" === e) {
				if (Q.contextmenu.is_open) return t.preventDefault();
				if (w(t, t.target.closest(".modal-preview-a"))) return;
				U.open_popup(S.item)
			} else if ("copy" === e) {
				var i = !!S.codemirror && S.codemirror.getValue(), a = i && b(i);
				F.toggle(a, J.get("copy text"))
			} else if ("fullscreen" === e) M(); else if ("save" === e) p(); else if ("toggle-codemirror-theme" === e) {
				let e = !(!S.codemirror || !S.codemirror.display) && S.codemirror.display.wrapper;
				if (!e) return;
				let t = S.codemirror_theme;
				S.codemirror_theme = "light" === t ? "dark" : "light", e.classList.replace("cm-s-one-" + t, "cm-s-one-" + S.codemirror_theme), D.popup.classList.replace("modal-codemirror-theme-" + t, "modal-codemirror-theme-" + S.codemirror_theme), j.set("files:codemirror_theme", S.codemirror_theme)
			} else t.target.classList.contains("modal-pos-el") && (n = e, o = t.target, n !== $ && (O($, "remove"), O(n, "add"), $ = n, D.pos_active.classList.remove("modal-pos-active"), D.pos_active = o, D.pos_active.classList.add("modal-pos-active"), j.set("files:modal:position", n)));
			var n, o
		})), U.open_modal = (e, i) => {
			if (S.open) return S.item !== e && A(Q.list.matchingItems.findIndex((t => t._values === e)) - S.index);
			S.open = !0, t = document.activeElement || null, D.popup.removeEventListener("transitionend", W), oe(!0), Z(), S.index = Q.list.matchingItems.findIndex((t => t._values === e)), S.has_nav = S.index > -1 && Q.list.matchingItems.length > 1, s(), B(e), i && u("push"), D.modal.style.removeProperty("display"), document.activeElement && D.popup.addEventListener("transitionend", (() => document.activeElement.blur()), {once: !0}), q(1).then((() => {
				["file", "dir"].includes(S.type) && x(0), k(!0)
			}))
		}, U.close_modal = (e = !0) => {
			if (S.open && (S.open = !1, l(), L(), oe(!1), D.popup.addEventListener("transitionend", W), k(), t && t.isConnected && t.focus(), _c.history && e)) return history.state ? history.replaceState({path: _c.current_path}, _c.current_dir.basename || "/", location.pathname + location.search) : history.back()
		}
	})();
	var fe = function (e, t) {
		var i, a, n, o, s, l, c, p, d, m, h, f, _, g, v, x, b, y = this, w = !1, C = !0, A = {
			timeToIdle: 3e3,
			timeToIdleOutside: 1e3,
			loadingIndicatorDelay: 1e3,
			addCaptionHTMLFn: function (e, i) {
				return e.title ? i.firstElementChild.innerHTML = e.title : t.resetEl(i.firstElementChild)
			},
			closeEl: !0,
			captionEl: !0,
			fullscreenEl: Y.fullscreen,
			zoomEl: !0,
			downloadEl: !1,
			mapEl: !0,
			playEl: !0,
			panoRotateEl: !0,
			counterEl: !0,
			arrowEl: !0,
			preloaderEl: !0,
			closeOnOutsideClick: !0,
			tapToClose: !1,
			clickToCloseNonZoomable: !1,
			clickToShowNextNonZoomable: !1,
			indexIndicatorSep: '<span class="popup-counter-separator">/</span>',
			fitControlsWidth: 1200
		}, L = function (e) {
			if (v) return !0;
			e = e || window.event, g.timeToIdle && g.mouseUsed && !p && z();
			for (var t, i, a = e.target || e.srcElement, n = 0; n < j.length; n++) (t = j[n]).onTap && a.classList.contains("pswp__" + t.name) && (t.onTap(), i = !0);
			i && (e.stopPropagation(), v = !0, setTimeout((function () {
				v = !1
			}), 30))
		}, H = function (e) {
			32 === e.keyCode && (Y.is_dual_input && y.toggleControls(!1), y.setIdle(!p))
		}, k = function (e, t, i) {
			e.classList[i ? "add" : "remove"]("pswp__" + t)
		}, M = function () {
			var e = 1 === g.getNumItemsFn();
			e !== _ && (k(i, "ui--one-slide", e), _ = e)
		}, V = 0, z = function () {
			clearTimeout(b), V = 0, p && y.setIdle(!1)
		}, E = function (e) {
			var t = (e = e || window.event).relatedTarget || e.toElement;
			t && "HTML" !== t.nodeName || (clearTimeout(b), b = setTimeout((function () {
				y.setIdle(!0)
			}), g.timeToIdleOutside))
		}, $ = function (e) {
			h !== e && (t.toggle_class(m, "pswp__spinner", !e), h = e)
		}, j = [{
			name: "caption", option: "captionEl", onInit: function (e) {
				a = e
			}
		}, {
			name: "button--download", option: "downloadEl", onInit: function (e) {
				l = e
			}, onTap: function () {
			}
		}, {
			name: "button--map", option: "mapEl", onInit: function (e) {
				c = e
			}, onTap: function () {
			}
		}, {name: "button--zoom", option: "zoomEl", onTap: e.toggleDesktopZoom}, {
			name: "counter", option: "counterEl", onInit: function (e) {
				n = e
			}
		}, {name: "button--close", option: "closeEl", onTap: e.close}, {
			name: "button--arrow--left", option: "arrowEl", onInit: function (e) {
				o = e
			}, onTap: function () {
				e.prev()
			}
		}, {
			name: "button--arrow--right", option: "arrowEl", onInit: function (e) {
				s = e
			}, onTap: function () {
				e.next()
			}
		}, {
			name: "button--fs", option: "fullscreenEl", onInit: function (e) {
				e
			}, onTap: function () {
				screenfull.toggle()
			}
		}, {
			name: "preloader", option: "preloaderEl", onInit: function (e) {
				m = e
			}
		}, {
			name: "button--play", option: "playEl", onTap: function () {
				Q.popup.toggle_play(!Q.popup.playing)
			}
		}, {name: "button--pano-rotate", option: "panoRotateEl", onTap: Q.popup.toggle_pano_rotate}];
		y.init = function () {
			var n, o, s, p;
			t.copy_unique(e.options, A), g = e.options, i = Q.popup.ui, (d = e.listen)("onVerticalDrag", (function (e) {
				C && e < .95 ? y.toggleControls() : !C && e >= .95 && y.toggleControls(!0)
			})), d("onPinchClose", (function (e) {
				C && e < .9 ? (y.toggleControls(), n = !0) : n && !C && e > .9 && y.toggleControls(!0)
			})), d("zoomGestureEnded", (function () {
				(n = !1) && !C && y.toggleControls(!0)
			})), d("beforeChange", y.update), g.downloadEl && d("afterChange", (function () {
				var t = r(e.currItem.item);
				l.setAttribute("href", t || "#"), l.style.display = t ? "" : "none"
			})), g.mapEl && d("afterChange", (function () {
				var t = e.currItem.item, i = !!(t && t.image && t.image.exif) && t.image.exif.gps;
				c.style.display = i ? "" : "none", c.setAttribute("href", i ? u(i) : "#")
			})), d("doubleTap", (function (t) {
				var i = e.currItem.initialZoomLevel;
				e.zoomTo(e.getZoomLevel() === i ? g.getDoubleTapZoom(!1, e.currItem) : i, t, 250)
			})), d("preventDragEvent", (function (e, t, i) {
				var a = e.target || e.srcElement;
				a && a.getAttribute("class") && e.type.indexOf("mouse") > -1 && (a.getAttribute("class").indexOf("__caption") > 0 || /(SMALL|STRONG|EM)/i.test(a.tagName)) && (i.prevent = !1, undefined())
			})), d("bindEvents", (function () {
				t.bind(i, "pswpTap click", L), t.bind(Q.popup.scrollwrap, "pswpTap", y.onGlobalTap), t.bind(document, "keydown", H)
			})), d("unbindEvents", (function () {
				x && clearInterval(x), t.unbind(document, "mouseout", E), t.unbind(document, "mousemove", z), t.unbind(i, "pswpTap click", L), t.unbind(Q.popup.scrollwrap, "pswpTap", y.onGlobalTap), t.unbind(document, "keydown", H)
			})), d("destroy", (function () {
				g.captionEl && a.classList.remove("pswp__caption--empty"), i.classList.add("pswp__ui--hidden"), b && clearTimeout(b), y.setIdle(!1)
			})), g.showAnimationDuration || i.classList.remove("pswp__ui--hidden"), d("initialZoomIn", (function () {
				g.showAnimationDuration && i.classList.remove("pswp__ui--hidden")
			})), d("initialZoomOut", (function () {
				i.classList.add("pswp__ui--hidden")
			})), (p = function (e) {
				if (e) for (var t = e.length, i = 0; i < t; i++) {
					o = e[i];
					for (var a = 0; a < j.length; a++) s = j[a], o.classList.contains("pswp__" + s.name) && (g[s.option] ? (o.classList.remove("pswp__element--disabled"), s.onInit && s.onInit(o)) : o.classList.add("pswp__element--disabled"))
				}
			})(i.children), p(Q.popup.topbar.children), M(), g.timeToIdle && d("mouseUsed", (function () {
				t.bind(document, "mousemove", z), t.bind(document, "mouseout", E), x = setInterval((function () {
					2 == ++V && y.setIdle(!0)
				}), g.timeToIdle / 2)
			})), g.preloaderEl && ($(!0), d("beforeChange", (function () {
				clearTimeout(f), f = setTimeout((function () {
					e.currItem && e.currItem.loading ? e.currItem.img && !e.currItem.img.naturalWidth && $(!1) : $(!0)
				}), g.loadingIndicatorDelay)
			})), d("imageLoadComplete", (function (t, i) {
				e.currItem === i && $(!0)
			})))
		}, y.setIdle = function (e) {
			p = e, k(i, "ui--idle", e), k(Q.popup.container, "container--idle", e)
		}, y.update = function () {
			if (C && e.currItem) {
				if (y.updateIndexIndicator(), g.captionEl) {
					var t = g.addCaptionHTMLFn(e.currItem, a);
					k(a, "caption--empty", !t)
				}
				w = !0
			} else w = !1;
			M()
		}, y.updateIndexIndicator = function () {
			g.counterEl && (n.innerHTML = e.getCurrentIndex() + 1 + g.indexIndicatorSep + g.getNumItemsFn()), !g.loop && g.arrowEl && g.getNumItemsFn() > 1 && (t.toggle_class(o, "pswp__element--disabled", 0 === e.getCurrentIndex()), t.toggle_class(s, "pswp__element--disabled", e.getCurrentIndex() === g.getNumItemsFn() - 1))
		}, y.onGlobalTap = function (t) {
			var i = (t = t || window.event).target || t.srcElement;
			if (!v) if (t.detail && "mouse" === t.detail.pointerType) {
				if (!t.detail.rightClick) if (("zoom" == g.click || g.getNumItemsFn() < 2 || e.getZoomLevel() > e.currItem.fitRatio) && i.classList.contains("pswp__img")) e.currItem.fitRatio < 1 && e.toggleDesktopZoom(t.detail.releasePoint); else if (0 === i.className.indexOf("pswp__")) {
					var a = (g.getNumItemsFn() > 2 || !e.getCurrentIndex()) && ("next" == g.click || t.detail.releasePoint.x > Q.popup.pswp.clientWidth / 2) ? "next" : "prev";
					e[a]()
				}
			} else Y.is_dual_input ? Y.legacy_ie || y.setIdle(!p) : y.toggleControls(!C)
		}, y.toggleControls = function (e) {
			C = e, e && !w && y.update(), k(i, "ui--hidden", !e)
		}
	}, _e = {
		bind: function (e, t, i, a) {
			var n = (a ? "remove" : "add") + "EventListener";
			t = t.split(" ");
			for (var o = 0; o < t.length; o++) t[o] && e[n](t[o], i, !1)
		}, createEl: function (e, t) {
			var i = document.createElement(t || "div");
			return e && (i.className = e), i
		}, resetEl: function (e) {
			for (; e.firstChild;) e.removeChild(e.firstChild)
		}, getScrollY: function () {
			return window.pageYOffset
		}, unbind: function (e, t, i) {
			_e.bind(e, t, i, !0)
		}, toggle_class: function (e, t, i) {
			e.classList[i ? "add" : "remove"](t)
		}, arraySearch: function (e, t, i) {
			for (var a = e.length; a--;) if (e[a][i] === t) return a;
			return -1
		}, copy_unique: function (e, t) {
			Object.keys(t).forEach((function (i) {
				e.hasOwnProperty(i) || (e[i] = t[i])
			}))
		}, easing: {
			sine: {
				out: function (e) {
					return Math.sin(e * (Math.PI / 2))
				}, inOut: function (e) {
					return -(Math.cos(Math.PI * e) - 1) / 2
				}
			}, cubic: {
				out: function (e) {
					return --e * e * e + 1
				}
			}
		}, features: {touch: Y.is_touch, raf: window.requestAnimationFrame, caf: window.cancelAnimationFrame, pointerEvent: !!window.PointerEvent || navigator.msPointerEnabled, is_mouse: Y.only_pointer}
	}, ge = function (e, t, i, a) {
		var n = this, o = {
			allowPanToNext: !0,
			spacing: .12,
			bgOpacity: 1,
			mouseUsed: Y.only_pointer,
			loop: !0,
			pinchToClose: !0,
			closeOnScroll: !0,
			closeOnVerticalDrag: !0,
			verticalDragRange: .75,
			hideAnimationDuration: 333,
			showAnimationDuration: 333,
			showHideOpacity: !1,
			focus: !0,
			escKey: !0,
			arrowKeys: !0,
			mainScrollEndFriction: .35,
			panEndFriction: .35,
			transition: "glide",
			play_transition: "glide",
			isClickableElement: function (e) {
				return "A" === e.tagName || "VIDEO" === e.tagName || e.closest(".time-control")
			},
			getDoubleTapZoom: function (e, t) {
				return e || t.initialZoomLevel < .7 ? 1 : 1.33
			},
			maxSpreadZoom: 1
		};
		Object.assign(o, a);
		var s, l, r, c, p, d, m, u, h, f, _, g, v, x, b, y, w, C, A, L, H, k, M, V, z, E, $, j, I, T, O, S, Z, R, D, P, N, B, q, F, U, W, X, G, K, J, ee, te, ie, ae, ne, oe = {x: 0, y: 0}, se = {x: 0, y: 0}, le = {x: 0, y: 0}, re = {}, ce = 0, pe = {}, de = {x: 0, y: 0}, me = 0, ue = [], he = !1, fe = function (e, t) {
			Object.assign(n, t.publicMethods), ue.push(e)
		}, ge = function (e) {
			var t = St();
			return e > t - 1 ? e - t : e < 0 ? t + e : e
		}, ve = {}, xe = function (e, t) {
			return ve[e] || (ve[e] = []), ve[e].push(t)
		}, be = function (e) {
			var t = ve[e];
			if (t) {
				var i = Array.prototype.slice.call(arguments);
				i.shift();
				for (var a = 0; a < t.length; a++) t[a].apply(n, i)
			}
		}, ye = function () {
			return (new Date).getTime()
		}, we = function (e) {
			ie = e, Q.popup.bg.style.opacity = e * o.bgOpacity
		}, Ce = function (e, t, i, a, o) {
			(!he || o && o !== n.currItem) && (a /= o ? o.fitRatio : n.currItem.fitRatio), e.transform = g + t + "px, " + i + "px, 0px) scale(" + a + ")"
		}, Ae = function (e) {
			G && !n.currItem.loadError && (e && (f > n.currItem.fitRatio ? he || (Ut(n.currItem, !1, !0), he = !0) : he && (Ut(n.currItem), he = !1)), Ce(G, le.x, le.y, f))
		}, Le = function (e) {
			e.container && Ce(e.container.style, e.initialPosition.x, e.initialPosition.y, e.initialZoomLevel, e)
		}, He = function (e, t) {
			t.transform = g + e + "px, 0px, 0px)"
		}, ke = function (e, t) {
			if (!o.loop && t) {
				var i = c + (de.x * ce - e) / de.x, a = Math.round(e - st.x);
				(i < 0 && a > 0 || i >= St() - 1 && a < 0) && (e = st.x + a * o.mainScrollEndFriction)
			}
			st.x = e, He(e, p)
		}, Me = function (e, t) {
			var i = lt[e] - pe[e];
			return se[e] + oe[e] + i - i * (t / _)
		}, Ve = function (e, t) {
			e.x = t.x, e.y = t.y, t.id && (e.id = t.id)
		}, ze = function (e) {
			e.x = Math.round(e.x), e.y = Math.round(e.y)
		}, Ee = function () {
			$.is_mouse || (e.classList.add("pswp--has_mouse"), V += " pswp--has_mouse", $.is_mouse = o.mouseUsed = !0), be("mouseUsed")
		}, $e = null, je = function () {
			$e && (_e.unbind(document, "mousemove", je), Ee()), $e = setTimeout((function () {
				$e = null
			}), 100)
		}, Ie = function (e, t) {
			var i = Nt(n.currItem, re, e);
			return t && (X = i), i
		}, Te = function (e) {
			return (e || n.currItem).initialZoomLevel
		}, Oe = function (e) {
			return (e || n.currItem).w > 0 ? o.maxSpreadZoom : 1
		}, Se = function (e, t, i, a) {
			return a === n.currItem.initialZoomLevel ? (i[e] = n.currItem.initialPosition[e], !0) : (i[e] = Me(e, a), i[e] > t.min[e] ? (i[e] = t.min[e], !0) : i[e] < t.max[e] && (i[e] = t.max[e], !0))
		}, Ze = function (e) {
			var t = "";
			if (o.escKey && 27 === e.keyCode ? t = "close" : o.arrowKeys && (37 === e.keyCode ? t = "prev" : 39 === e.keyCode && (t = "next")), !t || e.ctrlKey || e.altKey || e.shiftKey || e.metaKey) return !1;
			e.preventDefault(), n[t]()
		}, Re = function (e) {
			e && (N || P || K || Z) && (e.preventDefault(), e.stopPropagation())
		}, De = function () {
			n.setScrollOffset(0, _e.getScrollY())
		}, Pe = {}, Ne = 0, Be = function (e) {
			Pe[e] && (Pe[e].raf && M(Pe[e].raf), Ne--, delete Pe[e])
		}, qe = function (e) {
			Pe[e] && Be(e), Pe[e] || (Ne++, Pe[e] = {})
		}, Fe = function () {
			for (var e in Pe) Pe.hasOwnProperty(e) && Be(e)
		}, Ue = function (e, t, i, a, n, o, s) {
			var l, r = ye();
			qe(e);
			var c = function () {
				if (Pe[e]) {
					if ((l = ye() - r) >= a) return Be(e), o(i), void (s && s());
					o((i - t) * n(l / a) + t), Pe[e].raf = k(c)
				}
			};
			c()
		}, We = {
			shout: be, listen: xe, viewportSize: re, options: o, isMainScrollAnimating: function () {
				return K
			}, getZoomLevel: function () {
				return f
			}, getCurrentIndex: function () {
				return c
			}, isDragging: function () {
				return R
			}, isZooming: function () {
				return U
			}, setScrollOffset: function (e, t) {
				pe.x = e, E = pe.y = t
			}, applyZoomPan: function (e, t, i, a) {
				le.x = t, le.y = i, f = e, Ae(a)
			}, init: function () {
				if (!s && !l) {
					var i;
					for (n.framework = _e, n.template = e, V = e.className, s = !0, $ = _e.features, k = $.raf, M = $.caf, p = Q.popup.container.style, n.itemHolders = x = [{el: Q.popup.items[0], wrap: 0, index: -1}, {el: Q.popup.items[1], wrap: 0, index: -1}, {
						el: Q.popup.items[2],
						wrap: 0,
						index: -1
					}], x[0].el.style.display = x[2].el.style.display = "none", g = "translate" + (H ? "(" : "3d("), h = {
						resize: n.updateSize, orientationchange: function () {
							clearTimeout(j), j = setTimeout((function () {
								re.x !== Q.popup.scrollwrap.clientWidth && n.updateSize()
							}), 500)
						}, scroll: De, keydown: Ze, click: Re
					}, i = 0; i < ue.length; i++) n["init" + ue[i]]();
					if (t) (n.ui = new t(n, _e)).init();
					be("firstUpdate"), c = c || o.index || 0, (isNaN(c) || c < 0 || c >= St()) && (c = 0), n.currItem = Ot(c), e.setAttribute("aria-hidden", "false"), void 0 === E && (be("initialLayout"), E = z = _e.getScrollY());
					var a = "pswp--open" + (o.showHideOpacity ? " pswp--animate_opacity" : "") + (Y.is_pointer && ("zoom" == o.click || o.getNumItemsFn() < 2) ? " pswp--zoom-cursor" : "");
					for (DOMTokenList.prototype.add.apply(e.classList, a.split(" ")), n.updateSize(), d = -1, me = null, i = 0; i < 3; i++) He((i + d) * de.x, x[i].el.style);
					_e.bind(Q.popup.scrollwrap, u, n), xe("initialZoomInEnd", (function () {
						n.setContent(x[0], c - 1), n.setContent(x[2], c + 1), x[0].el.style.display = x[2].el.style.display = "block", o.focus && e.focus(), _e.bind(document, "keydown", n), _e.bind(Q.popup.scrollwrap, "click", n), $.is_mouse ? Ee() : Y.is_pointer && _e.bind(document, "mousemove", je), _e.bind(window, "resize scroll orientationchange", n), be("bindEvents")
					})), n.setContent(x[1], c), n.updateCurrItem(), e.classList.add("pswp--visible")
				}
			}, close: function () {
				s && (s = !1, l = !0, be("close"), setTimeout((function () {
					_e.unbind(window, "resize scroll orientationchange", n)
				}), 400), _e.unbind(window, "scroll", h.scroll), _e.unbind(document, "keydown", n), Y.is_pointer && _e.unbind(document, "mousemove", je), _e.unbind(Q.popup.scrollwrap, "click", n), R && _e.unbind(window, m, n), clearTimeout(j), be("unbindEvents"), Zt(n.currItem, null, !0, n.destroy))
			}, destroy: function () {
				be("destroy"), $t && clearTimeout($t), e.setAttribute("aria-hidden", "true"), e.className = V, _e.unbind(Q.popup.scrollwrap, u, n), _e.unbind(window, "scroll", n), pt(), Fe(), ve = {}
			}, panTo: function (e, t, i) {
				i || (e > X.min.x ? e = X.min.x : e < X.max.x && (e = X.max.x), t > X.min.y ? t = X.min.y : t < X.max.y && (t = X.max.y)), e == le.x && t == le.y || (le.x = e, le.y = t, Ae())
			}, handleEvent: function (e) {
				e = e || window.event, h[e.type] && h[e.type](e)
			}, goTo: function (e, t, i) {
				var a = i ? o.play_transition : o.transition;
				if ("slide" === a) Vt("swipe", 80 * e, {lastFlickDist: {x: 80, y: 0}, lastFlickOffset: {x: 80 * e, y: 0}, lastFlickSpeed: {x: 2 * e, y: 0}}); else {
					var s = (e = ge(e)) - c;
					me = s, c = e, n.currItem = Ot(c), ce -= s, ke(de.x * ce), Fe(), K = !1, Q.popup.image_anim && !Q.popup.image_anim.paused && Q.popup.image_anim.pause();
					var l = !!Q.popup.transitions.hasOwnProperty(a) && Q.popup.transitions[a](t);
					if (Q.popup.caption_transition_delay = l && l.duration || 0, n.updateCurrItem(), !l) return;
					var r = !!n.currItem.container && n.currItem.container.lastElementChild;
					r && (Q.popup.image_timer ? clearTimeout(Q.popup.image_timer) : Q.popup.image_anim = anime(Object.assign({targets: r}, l)), Q.popup.image_timer = setTimeout((function () {
						Q.popup.image_timer = !1
					}), 300))
				}
			}, next: function (e) {
				if (o.loop || c !== St() - 1) {
					var t = e ? o.play_transition : o.transition;
					n.goTo("slide" === t ? -1 : parseInt(c) + 1, 1, e)
				}
			}, prev: function () {
				(o.loop || 0 !== c) && n.goTo("slide" === o.transition ? 1 : parseInt(c) - 1, -1)
			}, updateCurrZoomItem: function (e) {
				e && be("beforeChange", 0);
				var t = x[1].el.children;
				G = t.length && t[0].classList.contains("pswp__zoom-wrap") ? t[0].style : null, X = n.currItem.bounds, _ = f = n.currItem.initialZoomLevel, le.x = X.center.x, le.y = X.center.y, e && be("afterChange")
			}, invalidateCurrItems: function () {
				v = !0;
				for (var e = 0; e < 3; e++) x[e].item && (x[e].item.needsUpdate = !0)
			}, updateCurrItem: function (e) {
				if (0 !== me) {
					var t, i = Math.abs(me);
					if (!(e && i < 2)) {
						n.currItem = Ot(c), he = !1, be("beforeChange", me), i >= 3 && (d += me + (me > 0 ? -3 : 3), i = 3);
						for (var a = 0; a < i; a++) me > 0 ? (t = x.shift(), x[2] = t, d++, He((d + 2) * de.x, t.el.style), n.setContent(t, c - i + a + 1 + 1)) : (t = x.pop(), x.unshift(t), d--, He(d * de.x, t.el.style), n.setContent(t, c + i - a - 1 - 1));
						if (G && 1 === Math.abs(me)) {
							var o = Ot(b);
							o.initialZoomLevel !== f && (Nt(o, re), Ut(o), Le(o))
						}
						me = 0, n.updateCurrZoomItem(), b = c, be("afterChange")
					}
				}
			}, updateSize: function (e) {
				if (re.x = Q.popup.scrollwrap.clientWidth, re.y = Q.popup.scrollwrap.clientHeight, De(), de.x = re.x + Math.round(re.x * o.spacing), de.y = re.y, ke(de.x * ce), be("beforeResize"), void 0 !== d) {
					for (var t, i, a, s = 0; s < 3; s++) t = x[s], He((s + d) * de.x, t.el.style), a = c + s - 1, o.loop && St() > 2 && (a = ge(a)), (i = Ot(a)) && (v || i.needsUpdate || !i.bounds) ? (n.cleanSlide(i), n.setContent(t, a), 1 === s && (n.currItem = i, n.updateCurrZoomItem(!0)), i.needsUpdate = !1) : -1 === t.index && a >= 0 && n.setContent(t, a), i && i.container && (Nt(i, re), Ut(i), Le(i));
					v = !1
				}
				_ = f = n.currItem.initialZoomLevel, (X = n.currItem.bounds) && (le.x = X.center.x, le.y = X.center.y, Ae(!0)), be("resize")
			}, zoomTo: function (e, t, i, a, n) {
				t && (_ = f, lt.x = Math.abs(t.x) - le.x, lt.y = Math.abs(t.y) - le.y, Ve(se, le));
				var o = Ie(e, !1), s = {};
				Se("x", o, s, e), Se("y", o, s, e);
				var l = f, r = {x: le.x, y: le.y};
				ze(s);
				var c = function (t) {
					1 === t ? (f = e, le.x = s.x, le.y = s.y) : (f = (e - l) * t + l, le.x = (s.x - r.x) * t + r.x, le.y = (s.y - r.y) * t + r.y), n && n(t), Ae(1 === t)
				};
				i ? Ue("customZoomTo", 0, 1, i, a || _e.easing.sine.inOut, c) : c(1)
			}
		}, Qe = {}, Xe = {}, Ye = {}, Ge = {}, Ke = {}, Je = [], et = {}, tt = [], it = {}, at = 0, nt = {x: 0, y: 0}, ot = 0, st = {x: 0, y: 0}, lt = {x: 0, y: 0}, rt = {x: 0, y: 0}, ct = function (e, t) {
			return it.x = Math.abs(e.x - t.x), it.y = Math.abs(e.y - t.y), Math.sqrt(it.x * it.x + it.y * it.y)
		}, pt = function () {
			B && (M(B), B = null)
		}, dt = function () {
			R && (B = k(dt), Lt())
		}, mt = function (e, t) {
			return !(!e || e === document || e === Q.popup.scrollwrap) && (t(e) ? e : mt(e.parentNode, t))
		}, ut = {}, ht = function (e, t) {
			return ut.prevent = !mt(e.target, o.isClickableElement), be("preventDragEvent", e, t, ut), ut.prevent
		}, ft = function (e, t) {
			return t.x = e.pageX, t.y = e.pageY, t.id = e.identifier, t
		}, _t = function (e, t, i) {
			i.x = .5 * (e.x + t.x), i.y = .5 * (e.y + t.y)
		}, gt = function () {
			var e = le.y - n.currItem.initialPosition.y;
			return 1 - Math.abs(e / (re.y / 2))
		}, vt = {}, xt = {}, bt = [], yt = function (e) {
			for (; bt.length > 0;) bt.pop();
			return L ? (ne = 0, Je.forEach((function (e) {
				0 === ne ? bt[0] = e : 1 === ne && (bt[1] = e), ne++
			}))) : e.type.indexOf("touch") > -1 ? e.touches && e.touches.length > 0 && (bt[0] = ft(e.touches[0], vt), e.touches.length > 1 && (bt[1] = ft(e.touches[1], xt))) : (vt.x = e.pageX, vt.y = e.pageY, vt.id = "", bt[0] = vt), bt
		}, wt = function (e, t) {
			var i, a, s, l, r = le[e] + t[e], c = t[e] > 0, p = st.x + t.x, d = st.x - et.x;
			if (i = r > X.min[e] || r < X.max[e] ? o.panEndFriction : 1, r = le[e] + t[e] * i, (o.allowPanToNext || f === n.currItem.initialZoomLevel) && (G ? "h" !== J || "x" !== e || P || (c ? (r > X.min[e] && (i = o.panEndFriction, X.min[e] - r, a = X.min[e] - se[e]), (a <= 0 || d < 0) && St() > 1 ? (l = p, d < 0 && p > et.x && (l = et.x)) : X.min.x !== X.max.x && (s = r)) : (r < X.max[e] && (i = o.panEndFriction, r - X.max[e], a = se[e] - X.max[e]), (a <= 0 || d > 0) && St() > 1 ? (l = p, d > 0 && p < et.x && (l = et.x)) : X.min.x !== X.max.x && (s = r))) : l = p, "x" === e)) return void 0 !== l && (ke(l, !0), q = l !== et.x), X.min.x !== X.max.x && (void 0 !== s ? le.x = s : q || (le.x += t.x * i)), void 0 !== l;
			!K && !q && f > n.currItem.fitRatio && (le[e] += t[e] * i)
		}, Ct = function (e) {
			if ("pointerdown" !== e.type || !(e.which > 1 || e.ctrlKey)) if (Tt) e.preventDefault(); else {
				if (ht(e, !0) && e.preventDefault(), be("pointerDown"), L) {
					var t = _e.arraySearch(Je, e.pointerId, "id");
					t < 0 && (t = Je.length), Je[t] = {x: e.pageX, y: e.pageY, id: e.pointerId}
				}
				var i = yt(e), a = i.length;
				F = null, Fe(), R && 1 !== a || (R = ee = !0, _e.bind(window, m, n), S = ae = te = Z = q = N = D = P = !1, J = null, be("firstTouchStart", i), Ve(se, le), oe.x = oe.y = 0, Ve(Ge, i[0]), Ve(Ke, Ge), et.x = de.x * ce, tt = [{
					x: Ge.x,
					y: Ge.y
				}], T = I = ye(), Ie(f, !0), pt(), dt()), !U && a > 1 && !K && !q && (_ = f, P = !1, U = D = !0, oe.y = oe.x = 0, Ve(se, le), Ve(Qe, i[0]), Ve(Xe, i[1]), _t(Qe, Xe, rt), lt.x = Math.abs(rt.x) - le.x, lt.y = Math.abs(rt.y) - le.y, W = ct(Qe, Xe))
			}
		}, At = function (e) {
			if (e.preventDefault(), L) {
				var t = _e.arraySearch(Je, e.pointerId, "id");
				if (t > -1) {
					var i = Je[t];
					i.x = e.pageX, i.y = e.pageY
				}
			}
			if (R) {
				var a = yt(e);
				if (J || N || U) F = a; else if (st.x !== de.x * ce) J = "h"; else {
					var n = Math.abs(a[0].x - Ge.x) - Math.abs(a[0].y - Ge.y);
					Math.abs(n) >= 10 && (J = n > 0 ? "h" : "v", F = a)
				}
			}
		}, Lt = function () {
			if (F) {
				var e = F.length;
				if (0 !== e) if (Ve(Qe, F[0]), Ye.x = Qe.x - Ge.x, Ye.y = Qe.y - Ge.y, U && e > 1) {
					if (Ge.x = Qe.x, Ge.y = Qe.y, !Ye.x && !Ye.y && function (e, t) {
						return e.x === t.x && e.y === t.y
					}(F[1], Xe)) return;
					Ve(Xe, F[1]), P || (P = !0);
					var t = ct(Qe, Xe), i = zt(t);
					i > n.currItem.initialZoomLevel + n.currItem.initialZoomLevel / 15 && (ae = !0);
					var a = 1, s = Te(), l = Oe();
					if (i < s) if (o.pinchToClose && !ae && _ <= n.currItem.initialZoomLevel) {
						var r = 1 - (s - i) / (s / 1.2);
						we(r), be("onPinchClose", r), te = !0
					} else (a = (s - i) / s) > 1 && (a = 1), i = s - a * (s / 3); else i > l && ((a = (i - l) / (6 * s)) > 1 && (a = 1), i = l + a * s);
					a < 0 && (a = 0), t, _t(Qe, Xe, nt), oe.x += nt.x - rt.x, oe.y += nt.y - rt.y, Ve(rt, nt), le.x = Me("x", i), le.y = Me("y", i), S = i > f, f = i, Ae()
				} else {
					if (!J) return;
					if (ee && (ee = !1, Math.abs(Ye.x) >= 10 && (Ye.x -= F[0].x - Ke.x), Math.abs(Ye.y) >= 10 && (Ye.y -= F[0].y - Ke.y)), Ge.x = Qe.x, Ge.y = Qe.y, 0 === Ye.x && 0 === Ye.y) return;
					if ("v" === J && o.closeOnVerticalDrag && f === n.currItem.initialZoomLevel) {
						oe.y += Ye.y, le.y += Ye.y;
						var c = gt();
						return Z = !0, be("onVerticalDrag", c), we(c), void Ae()
					}
					!function (e, t, i) {
						if (e - T > 50) {
							var a = tt.length > 2 ? tt.shift() : {};
							a.x = t, a.y = i, tt.push(a), T = e
						}
					}(ye(), Qe.x, Qe.y), N = !0, X = n.currItem.bounds, wt("x", Ye) || (wt("y", Ye), ze(le), Ae())
				}
			}
		}, Ht = function (e) {
			var t;
			if (be("pointerUp"), ht(e, !1) && e.preventDefault(), L) {
				var i = _e.arraySearch(Je, e.pointerId, "id");
				if (i > -1) if (t = Je.splice(i, 1)[0], navigator.msPointerEnabled) {
					t.type = {4: "mouse", 2: "touch", 3: "pen"}[e.pointerType], t.type || (t.type = e.pointerType || "mouse")
				} else t.type = e.pointerType || "mouse"
			}
			var a, s = yt(e), l = s.length;
			if ("mouseup" === e.type && (l = 0), 2 === l) return F = null, !0;
			1 === l && Ve(Ke, s[0]), 0 !== l || J || K || (t || ("mouseup" === e.type ? t = {x: e.pageX, y: e.pageY, type: "mouse"} : e.changedTouches && e.changedTouches[0] && (t = {x: e.changedTouches[0].pageX, y: e.changedTouches[0].pageY, type: "touch"})), be("touchRelease", e, t));
			var r = -1;
			if (0 === l && (R = !1, _e.unbind(window, m, n), pt(), U ? r = 0 : -1 !== ot && (r = ye() - ot)), ot = 1 === l ? ye() : -1, a = -1 !== r && r < 150 ? "zoom" : "swipe", U && l < 2 && (U = !1, 1 === l && (a = "zoomPointerUp"), be("zoomGestureEnded")), F = null, N || P || K || Z) if (Fe(), O || (O = kt()), O.calculateSwipeSpeed("x"), Z) {
				if (gt() < o.verticalDragRange) n.close(); else {
					var c = le.y, p = ie;
					Ue("verticalDrag", 0, 1, 300, _e.easing.cubic.out, (function (e) {
						le.y = (n.currItem.initialPosition.y - c) * e + c, we((1 - p) * e + p), Ae()
					})), be("onVerticalDrag", 1)
				}
			} else {
				if ((q || K) && 0 === l) {
					var d = Ge.x - Ke.x;
					if (Vt(a, d, O)) return;
					a = "zoomPointerUp"
				}
				K || ("swipe" === a ? !q && f > n.currItem.fitRatio && Mt(O) : Et())
			}
		}, kt = function () {
			var e, t, i = {
				lastFlickOffset: {}, lastFlickDist: {}, lastFlickSpeed: {}, slowDownRatio: {}, slowDownRatioReverse: {}, speedDecelerationRatio: {}, speedDecelerationRatioAbs: {}, distanceOffset: {}, backAnimDestination: {}, backAnimStarted: {}, calculateSwipeSpeed: function (a) {
					tt.length > 1 ? (e = ye() - T + 50, t = tt[tt.length - 2][a]) : (e = ye() - I, t = Ke[a]), i.lastFlickOffset[a] = Ge[a] - t, i.lastFlickDist[a] = Math.abs(i.lastFlickOffset[a]), i.lastFlickDist[a] > 20 ? i.lastFlickSpeed[a] = i.lastFlickOffset[a] / e : i.lastFlickSpeed[a] = 0, Math.abs(i.lastFlickSpeed[a]) < .1 && (i.lastFlickSpeed[a] = 0), i.slowDownRatio[a] = .95, i.slowDownRatioReverse[a] = 1 - i.slowDownRatio[a], i.speedDecelerationRatio[a] = 1
				}, calculateOverBoundsAnimOffset: function (e, t) {
					i.backAnimStarted[e] || (le[e] > X.min[e] ? i.backAnimDestination[e] = X.min[e] : le[e] < X.max[e] && (i.backAnimDestination[e] = X.max[e]), void 0 !== i.backAnimDestination[e] && (i.slowDownRatio[e] = .7, i.slowDownRatioReverse[e] = 1 - i.slowDownRatio[e], i.speedDecelerationRatioAbs[e] < .05 && (i.lastFlickSpeed[e] = 0, i.backAnimStarted[e] = !0, Ue("bounceZoomPan" + e, le[e], i.backAnimDestination[e], t || 300, _e.easing.sine.out, (function (t) {
						le[e] = t, Ae()
					})))))
				}, calculateAnimOffset: function (e) {
					i.backAnimStarted[e] || (i.speedDecelerationRatio[e] = i.speedDecelerationRatio[e] * (i.slowDownRatio[e] + i.slowDownRatioReverse[e] - i.slowDownRatioReverse[e] * i.timeDiff / 10), i.speedDecelerationRatioAbs[e] = Math.abs(i.lastFlickSpeed[e] * i.speedDecelerationRatio[e]), i.distanceOffset[e] = i.lastFlickSpeed[e] * i.speedDecelerationRatio[e] * i.timeDiff, le[e] += i.distanceOffset[e])
				}, panAnimLoop: function () {
					if (Pe.zoomPan && (Pe.zoomPan.raf = k(i.panAnimLoop), i.now = ye(), i.timeDiff = i.now - i.lastNow, i.lastNow = i.now, i.calculateAnimOffset("x"), i.calculateAnimOffset("y"), Ae(), i.calculateOverBoundsAnimOffset("x"), i.calculateOverBoundsAnimOffset("y"), i.speedDecelerationRatioAbs.x < .05 && i.speedDecelerationRatioAbs.y < .05)) return le.x = Math.round(le.x), le.y = Math.round(le.y), Ae(), void Be("zoomPan")
				}
			};
			return i
		}, Mt = function (e) {
			if (e.calculateSwipeSpeed("y"), X = n.currItem.bounds, e.backAnimDestination = {}, e.backAnimStarted = {}, Math.abs(e.lastFlickSpeed.x) <= .05 && Math.abs(e.lastFlickSpeed.y) <= .05) return e.speedDecelerationRatioAbs.x = e.speedDecelerationRatioAbs.y = 0, e.calculateOverBoundsAnimOffset("x"), e.calculateOverBoundsAnimOffset("y"), !0;
			qe("zoomPan"), e.lastNow = ye(), e.panAnimLoop()
		}, Vt = function (e, t, i) {
			var a, s, l;
			if (Q.popup.caption_transition_delay = 0, K || (at = c), "swipe" === e) {
				var r = i.lastFlickDist.x < 10;
				t > 30 && (r || i.lastFlickOffset.x > 20) ? s = -1 : t < -30 && (r || i.lastFlickOffset.x < -20) && (s = 1)
			}
			s && ((c += s) < 0 ? (c = o.loop ? St() - 1 : 0, l = !0) : c >= St() && (c = o.loop ? 0 : St() - 1, l = !0), l && !o.loop || (me += s, ce -= s, a = !0));
			var p, d = de.x * ce, m = Math.abs(d - st.x);
			return p = (a || d > st.x == i.lastFlickSpeed.x > 0) && Math.abs(i.lastFlickSpeed.x) > 0 ? Math.max(Math.min(m / Math.abs(i.lastFlickSpeed.x), 400), 250) : 333, at === c && (a = !1), K = !0, a && Q.popup.toggle_timer(!1), Ue("mainScroll", st.x, d, p, _e.easing.cubic.out, ke, (function () {
				Fe(), K = !1, at = -1, (a || at !== c) && n.updateCurrItem(), be("mainScrollAnimComplete")
			})), a && n.updateCurrItem(!0), a
		}, zt = function (e) {
			return 1 / W * e * _
		}, Et = function () {
			var e = f, t = Te(), i = Oe();
			f < t ? e = t : f > i && (e = i);
			var a, o = ie;
			return te && !S && !ae && f < t ? (n.close(), !0) : (te && (a = function (e) {
				we((1 - o) * e + o)
			}), n.zoomTo(e, 0, 200, _e.easing.cubic.out, a), !0)
		};
		fe("Gestures", {
			publicMethods: {
				initGestures: function () {
					var e = function (e, t, i, a, n) {
						y = e + t, w = e + i, C = e + a, A = n ? e + n : ""
					};
					(L = $.pointerEvent) && $.touch && ($.touch = !1), L ? e("pointer", "down", "move", "up", "cancel") : $.touch ? (e("touch", "start", "move", "end", "cancel"), H = !0) : e("mouse", "down", "move", "up"), m = w + " " + C + " " + A, u = y, L && !H && (H = Y.is_touch), n.likelyTouchDevice = H, h[y] = Ct, h[w] = At, h[C] = Ht, A && (h[A] = h[C]), $.dual_input && (u += " mousedown", m += " mousemove mouseup", h.mousedown = h[y], h.mousemove = h[w], h.mouseup = h[C]), H || (o.allowPanToNext = !1)
				}
			}
		});
		var $t, jt, It, Tt, Ot, St, Zt = function (t, i, a, s) {
			var l;
			$t && clearTimeout($t), Tt = !0, It = !0, t.initialLayout ? (l = t.initialLayout, t.initialLayout = null) : l = o.getThumbBoundsFn && o.getThumbBoundsFn(c, a);
			var p = a ? o.hideAnimationDuration : o.showAnimationDuration, d = function () {
				Be("initialZoom"), a ? (n.template.removeAttribute("style"), Q.popup.bg.style.removeProperty("opacity")) : (we(1), i && (i.style.display = "block"), e.classList.add("pswp--animated-in")), be("initialZoom" + (a ? "OutEnd" : "InEnd")), s && s(), Tt = !1
			};
			if (!p || !l || void 0 === l.x) return be("initialZoom" + (a ? "Out" : "In")), a ? e.style.opacity = 0 : (f = t.initialZoomLevel, Ve(le, t.initialPosition), Ae(), e.style.opacity = 1, we(1)), void (p ? setTimeout((function () {
				d()
			}), p) : d());
			let m = e => {
				G.setProperty("--clip-path-transition-duration", a ? "0.333s" : "0.433s"), G.setProperty("--clip-path", `inset(${e ? `${e.y}% ${e.x}%` : "0% 0%"})`)
			};
			!function () {
				var i = r, s = !n.currItem.src || n.currItem.loadError || o.showHideOpacity;
				t.miniImg && (t.miniImg.style.webkitBackfaceVisibility = "hidden"), a || (f = l.w / t.w, le.x = l.x, le.y = l.y - z, Q.popup[s ? "pswp" : "bg"].style.opacity = .001, Ae());
				let c = (() => {
					if (!l || !l.img) return;
					let e = l.img.offsetWidth, t = l.img.offsetHeight;
					if (!e || !t) return;
					let i = Math.max((l.w - e) / l.w * 50, 0), a = Math.max((l.h - t) / l.h * 50, 0);
					return i < 1 && a < 1 ? void 0 : {x: i, y: a}
				})();
				c && m(a ? 0 : c), qe("initialZoom"), a && !i && e.classList.remove("pswp--animated-in"), s && (a ? _e.toggle_class(e, "pswp--animate_opacity", !i) : setTimeout((function () {
					e.classList.add("pswp--animate_opacity")
				}), 30)), $t = setTimeout((function () {
					if (be("initialZoom" + (a ? "Out" : "In")), c && m(a ? c : 0), a) {
						var n = l.w / t.w, o = {x: le.x, y: le.y}, r = f, u = ie, h = function (t) {
							1 === t ? (f = n, le.x = l.x, le.y = l.y - E) : (f = (n - r) * t + r, le.x = (l.x - o.x) * t + o.x, le.y = (l.y - E - o.y) * t + o.y), Ae(), s ? e.style.opacity = 1 - t : we(u - t * u)
						};
						i ? Ue("initialZoom", 0, 1, p, _e.easing.cubic.out, h, d) : (h(1), $t = setTimeout(d, p + 20))
					} else f = t.initialZoomLevel, Ve(le, t.initialPosition), Ae(), we(1), s ? e.style.opacity = 1 : we(1), $t = setTimeout(d, p + 20)
				}), a ? 10 : 20)
			}()
		}, Rt = {}, Dt = [], Pt = {
			index: 0, errorMsg: '<div class="pswp__error-msg"><a href="%url%" target="_blank">The image</a> could not be loaded.</div>', preload: [1, 1], getNumItemsFn: function () {
				return jt.length
			}
		}, Nt = function (e, t, i) {
			if (e.src && !e.loadError) {
				var a = !i;
				if (Rt.x = t.x, Rt.y = t.y, a) {
					var n = Rt.x / e.w, o = Rt.y / e.h;
					e.fitRatio = n < o ? n : o, (i = e.fitRatio) > 1 && (i = 1), e.initialZoomLevel = i, e.bounds || (e.bounds = {center: {x: 0, y: 0}, max: {x: 0, y: 0}, min: {x: 0, y: 0}})
				}
				if (!i) return;
				return function (e, t, i) {
					var a = e.bounds;
					a.center.x = Math.round((Rt.x - t) / 2), a.center.y = Math.round((Rt.y - i) / 2), a.max.x = t > Rt.x ? Math.round(Rt.x - t) : a.center.x, a.max.y = i > Rt.y ? Math.round(Rt.y - i) : a.center.y, a.min.x = t > Rt.x ? 0 : a.center.x, a.min.y = i > Rt.y ? 0 : a.center.y
				}(e, e.w * i, e.h * i), a && i === e.initialZoomLevel && (e.initialPosition = e.bounds.center), e.bounds
			}
			return e.w = e.h = 0, e.initialZoomLevel = e.fitRatio = 1, e.bounds = {center: {x: 0, y: 0}, max: {x: 0, y: 0}, min: {x: 0, y: 0}}, e.initialPosition = e.bounds.center, e.bounds
		}, Bt = function (e, t, i, a, o, s) {
			t.loadError || a && (t.imageAppended = !0, Ut(t, a, t === n.currItem && he), i.appendChild(a), s && setTimeout((function () {
				t && t.loaded && t.placeholder && (t.placeholder.style.display = "none", t.placeholder = null)
			}), 500))
		}, qt = function (e) {
			e.loading = !0, e.loaded = !1;
			var t = e.img = _e.createEl("pswp__img", "img"), i = function () {
				e.loading = !1, e.loaded = !0, e.loadComplete ? e.loadComplete(e) : e.img = null, t.onload = t.onerror = null, t = null
			};
			return t.onload = i, t.onerror = function () {
				e.loadError = !0, i()
			}, t.src = e.src, t
		}, Ft = function (e, t) {
			if (e.src && e.loadError && e.container) return t && _e.resetEl(e.container), e.container.innerHTML = o.errorMsg.replace("%url%", e.src), !0
		}, Ut = function (e, t, i) {
			if (e.src) {
				t || (t = e.container.lastElementChild);
				var a = i ? e.w : Math.round(e.w * e.fitRatio), n = i ? e.h : Math.round(e.h * e.fitRatio);
				e.placeholder && !e.loaded && (e.placeholder.style.width = a + "px", e.placeholder.style.height = n + "px"), t.style.width = a + "px", t.style.height = n + "px"
			}
		}, Wt = function () {
			if (Dt.length) {
				for (var e, t = 0; t < Dt.length; t++) (e = Dt[t]).holder.index === e.index && Bt(e.index, e.item, e.baseDiv, e.img, 0, e.clearPlaceholder);
				Dt = []
			}
		};
		fe("Controller", {
			publicMethods: {
				lazyLoadItem: function (e) {
					e = ge(e);
					var t = Ot(e);
					t && (!t.loaded && !t.loading || v) && (be("gettingData", e, t), t.src && qt(t))
				}, initController: function () {
					_e.copy_unique(o, Pt), n.items = jt = i, Ot = n.getItemAt, St = o.getNumItemsFn, o.loop, St() < 3 && (o.loop = !1), xe("beforeChange", (function (e) {
						var t, i = o.preload, a = null === e || e >= 0, s = Math.min(i[0], St()), l = Math.min(i[1], St());
						for (t = 1; t <= (a ? l : s); t++) n.lazyLoadItem(c + t);
						for (t = 1; t <= (a ? s : l); t++) n.lazyLoadItem(c - t)
					})), xe("initialLayout", (function () {
						n.currItem.initialLayout = o.getThumbBoundsFn && o.getThumbBoundsFn(c)
					})), xe("mainScrollAnimComplete", Wt), xe("initialZoomInEnd", Wt), xe("destroy", (function () {
						for (var e, t = 0; t < jt.length; t++) (e = jt[t]).container && (e.container = null), e.placeholder && (e.placeholder = null), e.img && (e.img = null), e.preloader && (e.preloader = null), e.loadError && (e.loaded = e.loadError = !1);
						Dt = null
					}))
				}, getItemAt: function (e) {
					return e >= 0 && (void 0 !== jt[e] && jt[e])
				}, setContent: function (e, t) {
					o.loop && (t = ge(t));
					var i = n.getItemAt(e.index);
					i && (i.container = null);
					var a, l = n.getItemAt(t);
					if (l) {
						be("gettingData", t, l), e.index = t, e.item = l;
						var r = l.container = _e.createEl("pswp__zoom-wrap");
						if (!l.src && l.html && (l.html.tagName ? r.appendChild(l.html) : r.innerHTML = l.html), Ft(l), Nt(l, re), !l.src || l.loadError || l.loaded) l.src && !l.loadError && ((a = _e.createEl("pswp__img", "img")).style.opacity = 1, a.src = l.src, Ut(l, a), Bt(0, l, r, a)); else {
							l.loadComplete = function (i) {
								if (s) {
									if (e && e.index === t) {
										if (Ft(i, !0)) return i.loadComplete = i.img = null, Nt(i, re), Le(i), void (e.index === c && n.updateCurrZoomItem());
										i.imageAppended ? !Tt && i.placeholder && (i.placeholder.style.display = "none", i.placeholder = null) : K || Tt ? Dt.push({item: i, baseDiv: r, img: i.img, index: t, holder: e, clearPlaceholder: !0}) : Bt(0, i, r, i.img, 0, !0)
									}
									i.loadComplete = null, i.img = null, be("imageLoadComplete", t, i)
								}
							};
							var p = l.msrc && (l.msrc !== l.src || !It), d = _e.createEl("pswp__img pswp__img--placeholder" + (p ? "" : " pswp__img--placeholder--blank"), p ? "img" : "");
							p && (d.src = l.msrc), Ut(l, d), r.appendChild(d), l.placeholder = d, l.loading || qt(l), It ? Bt(0, l, r, l.img, 0, !0) : Dt.push({item: l, baseDiv: r, img: l.img, index: t, holder: e})
						}
						It || t !== c ? Le(l) : (G = r.style, Zt(l, a || l.img)), _e.resetEl(e.el), e.el.appendChild(r)
					} else _e.resetEl(e.el)
				}, cleanSlide: function (e) {
					e.img && (e.img.onload = e.img.onerror = null), e.loaded = e.loading = e.img = e.imageAppended = !1
				}
			}
		});
		var Qt, Xt, Yt = {}, Gt = function (e, t, i) {
			var a = document.createEvent("CustomEvent"), n = {origEvent: e, pointerType: i || "touch", releasePoint: t, target: e.target, rightClick: "mouse" === i && 3 === e.which};
			a.initCustomEvent("pswpTap", !0, !0, n), e.target.dispatchEvent(a)
		};
		fe("Tap", {
			publicMethods: {
				initTap: function () {
					xe("firstTouchStart", n.onTapStart), xe("touchRelease", n.onTapRelease), xe("destroy", (function () {
						Yt = {}, Qt = null
					}))
				}, onTapStart: function (e) {
					e.length > 1 && (clearTimeout(Qt), Qt = null)
				}, onTapRelease: function (e, t) {
					var i, a;
					if (t && (!N && !D && !Ne && (!L || Q.popup.container.contains(e.target)))) {
						var n = t;
						if (Qt && (clearTimeout(Qt), Qt = null, i = n, a = Yt, Math.abs(i.x - a.x) < 25 && Math.abs(i.y - a.y) < 25)) return void be("doubleTap", n);
						if ("mouse" === t.type) return void Gt(e, t, "mouse");
						if ("A" === e.target.tagName) return;
						if ("BUTTON" === e.target.tagName || e.target.classList.contains("pswp__single-tap")) return void Gt(e, t);
						Ve(Yt, n), Qt = setTimeout((function () {
							Gt(e, t), Qt = null
						}), 300)
					}
				}
			}
		}), fe("DesktopZoom", {
			publicMethods: {
				initDesktopZoom: function () {
					Y.is_dual_input ? xe("mouseUsed", (function () {
						n.setupDesktopZoom()
					})) : Y.is_pointer && n.setupDesktopZoom(!0)
				}, setupDesktopZoom: function (t) {
					Xt = {};
					var i = "wheel mousewheel DOMMouseScroll";
					xe("bindEvents", (function () {
						_e.bind(e, i, n.handleMouseWheel)
					})), xe("unbindEvents", (function () {
						Xt && _e.unbind(e, i, n.handleMouseWheel)
					})), n.mouseZoomedIn = !1;
					var a, o = function () {
						n.mouseZoomedIn && (e.classList.remove("pswp--zoomed-in"), n.mouseZoomedIn = !1), _e.toggle_class(e, "pswp--zoom-allowed", f < 1), s()
					}, s = function () {
						a && (e.classList.remove("pswp--dragging"), a = !1)
					};
					xe("resize", o), xe("afterChange", o), xe("pointerDown", (function () {
						n.mouseZoomedIn && (a = !0, e.classList.add("pswp--dragging"))
					})), xe("pointerUp", s), t || o()
				}, handleMouseWheel: function (e) {
					if (f <= n.currItem.fitRatio) return !o.closeOnScroll || Ne || R ? e.preventDefault() : Math.abs(e.deltaY) > 2 && (r = !0, n.close()), !0;
					if (e.stopPropagation(), Xt.x = 0, "deltaX" in e) 1 === e.deltaMode ? (Xt.x = 18 * e.deltaX, Xt.y = 18 * e.deltaY) : (Xt.x = e.deltaX, Xt.y = e.deltaY); else if ("wheelDelta" in e) e.wheelDeltaX && (Xt.x = -.16 * e.wheelDeltaX), e.wheelDeltaY ? Xt.y = -.16 * e.wheelDeltaY : Xt.y = -.16 * e.wheelDelta; else {
						if (!("detail" in e)) return;
						Xt.y = e.detail
					}
					Ie(f, !0);
					var t = le.x - Xt.x, i = le.y - Xt.y;
					e.preventDefault(), n.panTo(t, i)
				}, toggleDesktopZoom: function (t) {
					t = t || {x: re.x / 2 + pe.x, y: re.y / 2 + pe.y};
					var i = o.getDoubleTapZoom(!0, n.currItem), a = f === i;
					n.mouseZoomedIn = !a, n.zoomTo(a ? n.currItem.initialZoomLevel : i, t, 333), _e.toggle_class(e, "pswp--zoomed-in", !a)
				}
			}
		});
		var Kt, Jt, ei, ti, ii, ai, ni, oi, si, li, ri = {history: !0}, ci = function () {
			return li.hash.substring(1)
		}, pi = function () {
			Kt && clearTimeout(Kt), ei && clearTimeout(ei)
		}, di = function () {
			if (ei && clearTimeout(ei), Ne || R) ei = setTimeout(di, 500); else {
				ti ? clearTimeout(Jt) : ti = !0;
				var e = c + 1, t = Ot(c);
				t.hasOwnProperty("pid") && (e = t.pid);
				var i = (ai ? ai + "&" : "") + "pid=" + e;
				ni || -1 === li.hash.indexOf(i) && (si = !0);
				var a = li.href.split("#")[0] + "#" + i;
				"#" + i !== window.location.hash && history[ni ? "replaceState" : "pushState"]("", document.title, a), ni = !0, Jt = setTimeout((function () {
					ti = !1
				}), 60)
			}
		};
		fe("History", {
			publicMethods: {
				initHistory: function () {
					if (_e.copy_unique(o, ri), o.history) {
						li = window.location, si = !1, oi = !1, ni = !1, ai = ci(), xe("afterChange", n.updateURL), xe("unbindEvents", (function () {
							_e.unbind(window, "hashchange", n.onHashChange)
						})), history.scrollRestoration && (history.scrollRestoration = "manual");
						var e = function () {
							ii = !0, oi || (si ? history.back() : ai ? li.hash = ai : history.pushState("", document.title, li.pathname + li.search)), pi(), history.scrollRestoration && (history.scrollRestoration = "auto")
						};
						xe("unbindEvents", (function () {
							r && e()
						})), xe("destroy", (function () {
							ii || e()
						}));
						var t = ai.indexOf("pid=");
						t > -1 && "&" === (ai = ai.substring(0, t)).slice(-1) && (ai = ai.slice(0, -1)), setTimeout((function () {
							s && _e.bind(window, "hashchange", n.onHashChange)
						}), 40)
					}
				}, onHashChange: function () {
					if (ci() === ai) return oi = !0, void n.close()
				}, updateURL: function () {
					pi(), ni ? Kt = setTimeout(di, 800) : di()
				}
			}
		}), Object.assign(n, We)
	};

	class ve {
		static active_el;
		static expand_button;
		static menu_root;
		static has_uls;
		static has_uls_root;
		static has_uls_not_root;
		static menu_open;
		static menu_expanded;
		static toggle_duration = 200;

		static init() {
			X.sidebar = _id("sidebar"), X.sidebar_inner = _id("sidebar-inner"), X.sidebar_menu = _id("sidebar-menu"), X.sidebar_toggle = _id("sidebar-toggle"), X.sidebar_bg = _id("sidebar-bg"), X.sidebar_topbar = _id("sidebar-topbar"), this.is_large_screen() && j.get_option("files:menu-open", _c.menu_show) || document.documentElement.classList.add("sidebar-closed"), X.sidebar_toggle.innerHTML = U.get_svg_icon_multi("menu", "menu_back"), X.sidebar_toggle.addEventListener("click", (() => this.toggle_open())), X.sidebar_bg.addEventListener("click", (() => this.toggle_open())), this.get_menu()
		}

		static is_large_screen() {
			return matchMedia("(min-width: 992px)").matches
		}

		static toggle_open() {
			j.set_option("files:menu-open", _c.menu_show, !document.documentElement.classList.toggle("sidebar-closed"))
		}

		static get_menu() {
			const e = !!_c.config.localStorage_cache && j.get_json("files:menu:" + _c.menu_cache_hash);
			return e ? _c.menu_cache_validate || _c.cache && !_c.menu_cache_file ? e.some((e => e.path.includes("/"))) ? void this.load_menu(e) : this.create_menu(e, "localStorage valid [root dirs only]") : this.create_menu(e, "localStorage valid [menu_cache_validate disabled]") : this.load_menu()
		}

		static load_menu(e) {
			X.sidebar_menu.classList.add("sidebar-spinner"), I({
				params: !_c.menu_cache_file && [_c.cache ? `menu_cache_hash=${_c.menu_cache_hash}` : 0, e ? "localstorage=1" : 0].filter(Boolean).join("&"),
				method: _c.menu_cache_file ? "GET" : "POST",
				url: _c.menu_cache_file || _c.script + "?action=dirs",
				json_response: !0,
				complete: (t, i, a) => this.loaded(t, i, a, e)
			})
		}

		static loaded(e, t, i, a) {
			return X.sidebar_menu.classList.remove("sidebar-spinner"), i && e && !e.error && Object.keys(e).length ? e.localstorage && a ? this.create_menu(a, "localStorage valid [server]") : (this.create_menu(e, "menu from " + (_c.menu_cache_file ? "JSON cache" : "xmlhttp")), void (Y.local_storage && _c.config.localStorage_cache && setTimeout((() => {
				U.clean_localstorage(), j.set("files:menu:" + _c.menu_cache_hash, t)
			}), 1e3))) : (ie(), E(e.error || "Error or no dirs!"), F.toggle(!1, e.error || "Error or no dirs!"))
		}

		static create_menu(e, t) {
			ie(), E("[MENU] " + t, e), e.forEach((e => {
				_c.dirs[e.path] || (_c.dirs[e.path] = e)
			})), this.menu_open = j.get_json("files:menu-expanded:" + _c.location_hash) || {}, Object.keys(this.menu_open).forEach((e => {
				_c.dirs[e] || delete this.menu_open[e]
			})), this.create_menu_html(e), this.menu_root = X.sidebar_menu.firstChild, this.get_has_uls(), _class("menu-li", this.menu_root).forEach((e => {
				const t = _c.dirs[e.dataset.path];
				t && (t.menu_li = e)
			})), this.set_active(_c.current_path || _c.start_path || ""), this.set_menu_scroll(), this.set_menu_toggle(), _c.transitions && 1 == getComputedStyle(document.body).getPropertyValue("opacity") && anime({targets: this.menu_root, opacity: [0, 1], easing: "easeOutQuad", duration: 300}), C(this.menu_root, (e => {
				if (Q.contextmenu.is_open) return e.preventDefault();
				if (e.target === this.menu_root) return;
				const t = "A" === e.target.nodeName, i = t ? e.target.parentElement : e.target.closest(".menu-li"), a = t ? e.target : i.firstElementChild;
				if (!w(e, a)) if (t && a !== this.active_el) U.get_files(i.dataset.path, "push"), this.is_large_screen() ? document.documentElement.classList.contains("sidebar-closed") && y(X.sidebar, "sidebar-clicked", null, 1e3) : this.toggle_open(); else if (!t || i.classList.contains("has-ul")) {
					const e = !i.classList.contains("menu-li-open");
					this.menu_open_manager(i, e), this.ul_anime(i, e)
				}
			}))
		}

		static create_menu_html(e) {
			let t = "", i = 0, a = 0, n = !1;
			e.forEach((e => {
				if (!e.path) return;
				let o = (e.path.match(/\//g) || []).length + 1, s = o - i;
				i = o, a += s, n && (t += this.add_li(n, s > 0)), t += s > 0 ? `<ul style="--depth:${a - 1}" class="menu-${n ? "ul" : "root"}">` : "</li>" + "</ul></li>".repeat(-s), n = _c.dirs[e.path]
			})), t += this.add_li(n, !1) + "</li></ul>".repeat(a), X.sidebar_menu.innerHTML = t
		}

		static add_li(e, t) {
			let i = "menu-li", o = "menu-a", s = e.path ? (e.path.match(/\//g) || []).length + 1 : 0, l = "folder" + (e.is_readable ? e.is_link ? "_link" : "" : "_forbid"), r = a(e.path);
			return t ? i += " has-ul menu-li-" + (this.menu_open[e.path] ? "open" : "closed") : e.is_readable || (o += " menu-a-forbidden"), `<li data-level="${s}" data-path="${r}" class="${i}"><a href="${c(e)}" class="${o}" data-path="${r}"${ae.draggable()}>${t ? U.get_svg_icon_multi_class("button-icon menu-icon menu-icon-toggle", "plus", "minus") + U.get_svg_icon_multi_class("menu-icon menu-icon-folder menu-icon-folder-toggle", l, "folder_plus", "folder_minus") : U.get_svg_icon_class(l, "menu-icon menu-icon-folder")}${n(e.basename)}</a>`
		}

		static get_has_uls() {
			this.has_uls = _class("has-ul", this.menu_root), this.has_uls_root = Array.from(this.menu_root.children).filter((e => e.classList.contains("has-ul"))), this.has_uls_not_root = this.has_uls.filter((e => !this.has_uls_root.includes(e)))
		}

		static set_active(e) {
			this.active_el && this.active_el.classList.remove("menu-spinner", "menu-active");
			const t = _c.dirs[e];
			this.active_el = !(!t || !t.menu_li) && t.menu_li.firstElementChild, this.active_el && this.active_el.classList.add("menu-active")
		}

		static set_menu_scroll() {
			if (!Y.local_storage) return;
			const e = j.get("files:menu-scroll" + _c.location_hash);
			e && (X.sidebar_menu.scrollTop = e), C(X.sidebar_menu, A((() => {
				j.set("files:menu-scroll" + _c.location_hash, X.sidebar_menu.scrollTop, !0)
			}), 1e3), "scroll")
		}

		static set_menu_toggle() {
			this.menu_expanded = this.has_uls_root.length && Object.keys(this.menu_open).length === this.has_uls.length, X.sidebar_topbar.innerHTML = `<button id="menu-toggle" class="button-icon${this.has_uls_root.length ? "" : " not-expandable"}${this.menu_expanded ? " is-expanded" : ""}" title="${J.get(this.menu_expanded ? "collapse menu" : "expand menu")}">${U.get_svg_icon_multi("plus", "minus")}</button>`, this.expand_button = X.sidebar_topbar.lastElementChild, C(this.expand_button, (e => {
				if (!this.has_uls_root.length) return;
				let t = [], i = [], a = !1, n = window.innerHeight;
				if (this.menu_expanded) this.has_uls_root.forEach((e => {
					if (!e.classList.contains("menu-li-open")) return;
					if (a) return t.push(e);
					if (e.getBoundingClientRect().top <= n) return i.push(e);
					t.push(e), a = !0
				})), t.length && t.forEach((e => this.li_close(e))), i.length && i.forEach((e => this.ul_anime(e, !1))), k("menu_inner_close", (() => {
					this.has_uls_not_root.forEach((e => this.li_close(e)))
				}), i.length ? this.toggle_duration + 10 : 10); else {
					let e = this.has_uls;
					this.has_uls.length > 100 && (e = this.has_uls_root, this.has_uls_not_root.forEach((e => this.li_open(e)))), e.forEach((e => {
						if (e.classList.contains("menu-li-open")) return;
						if (a || !e.offsetParent) return t.push(e);
						if (e.getBoundingClientRect().top <= n && e.lastElementChild.children.length <= 50) return i.push(e);
						t.push(e), a = !0
					})), t.length && t.forEach((e => this.li_open(e))), i.length && i.forEach((e => this.ul_anime(e, !0))), clearTimeout(H.menu_inner_close)
				}
				this.menu_open_manager("all", !this.menu_expanded)
			}))
		}

		static menu_open_manager(e, t) {
			"all" === e ? t ? this.has_uls.forEach((e => this.menu_open[e.dataset.path] = !0)) : this.menu_open = {} : t ? this.menu_open[e.dataset.path] = !0 : delete this.menu_open[e.dataset.path], this.update_expanded()
		}

		static update_expanded() {
			const e = Object.keys(this.menu_open).length, t = this.has_uls_root.length && e === this.has_uls.length;
			this.menu_expanded !== t && (this.menu_expanded = t, Y.is_pointer && (this.expand_button.title = J.get(t ? "collapse menu" : "expand menu")), this.expand_button.classList.toggle("is-expanded", t)), Y.local_storage && k("menu_expanded_localStorage", (() => {
				j.set("files:menu-expanded:" + _c.location_hash, !!e && JSON.stringify(this.menu_open), !0)
			}), 1e3)
		}

		static ul_anime(e, t) {
			const i = e.lastElementChild;
			i.style.display = "block", anime.remove(i);
			const a = {
				targets: i, translateY: t ? [-2, 0] : -2, height: [i.clientHeight + "px", t ? i.scrollHeight + "px" : 0], opacity: t ? 1 : 0, easing: "cubicBezier(.6,0,.1,1)", duration: this.toggle_duration, complete: () => {
					i.style.cssText = "--depth:" + (e.dataset.level || 0)
				}
			};
			return anime(a), t ? this.li_open(e) : this.li_close(e)
		}

		static li_open(e) {
			e.classList.replace("menu-li-closed", "menu-li-open")
		}

		static li_close(e) {
			e.classList.replace("menu-li-open", "menu-li-closed")
		}

		static loading(e) {
			this.active_el && this.active_el.classList.toggle("menu-spinner", !!e)
		}

		static update() {
			this.get_has_uls(), this.expand_button.classList.toggle("not-expandable", !this.has_uls_root.length), this.menu_open = {}, this.has_uls.forEach((e => {
				e.classList.contains("menu-li-open") && (this.menu_open[e.dataset.path] = !0)
			})), this.update_expanded()
		}
	}

	function xe() {
		const e = e => q(100).then((() => {
			e && e.remove()
		}));
		[".modal", "#files"].forEach((function (t) {
			yall({
				observeChanges: !0, observeRootSelector: t, lazyClass: "files-lazy", threshold: 300, events: {
					load: function (t) {
						let i = t.target;
						if (i.classList.contains("files-folder-preview")) {
							let t = i.naturalWidth;
							return t && 1 === t ? e(i) : (i.style.setProperty("--ratio", i.naturalWidth / i.naturalHeight), i.style.opacity = 1)
						}
						0 === t.target.src.indexOf("https://img.youtube.com/") && 1280 !== i.naturalWidth && (t.target.src = `https://img.youtube.com/vi/${t.target.src.split("/")[4]}/mqdefault.jpg`);
						let a = i.parentElement;
						if (["grid", "rows", "columns"].includes(_c.layout)) {
							let e = a.style;
							e.setProperty("--files-data-transition-duration", "0s"), q(250).then((() => e.removeProperty("--files-data-transition-duration")))
						}
						i.classList.remove("files-img-placeholder"), a.classList.add("files-a-loaded")
					}, error: {
						listener: t => {
							t.target.classList.contains("files-folder-preview") && e(t.target)
						}
					}
				}
			})
		})), document.body.classList.remove("body-loading"), U.topbar_dropdowns_init(), !_c.prevent_right_click && _c.context_menu && (X.files_container && X.files_container.addEventListener("contextmenu", (e => {
			let t = e.target.closest(".files-a");
			U.create_contextmenu(e, "files", t || X.files_container, t ? _c.files[t.dataset.name] : _c.current_dir)
		})), X.sidebar_menu && X.sidebar_menu.addEventListener("contextmenu", (e => {
			let t = e.target.closest(".menu-a"), i = !!t && t.parentElement;
			U.create_contextmenu(e, "sidebar", t || X.sidebar_menu, _c.dirs[i ? i.dataset.path : ""])
		}))), anime({targets: document.body, opacity: [0, 1], duration: 500, easing: "easeOutQuad", complete: U.init_files})
	}

	_c.menu_exists && ve.init(), (() => {
		function e(e, t) {
			Object.assign(Q.sort, {sort: e, order: t, multi: "asc" === t ? 1 : -1, index: Q.sort.keys.indexOf(e), prop: Q.sort.sorting[e].prop})
		}

		Q.sort = {sorting: {name: {prop: "basename", order: "asc"}, kind: {prop: "ext", order: "asc"}, size: {prop: "filesize", order: "desc"}, date: {prop: "mtime", order: "desc"}, shuffle: {prop: "mtime", order: "desc"}}}, Q.sort.keys = Object.keys(Q.sort.sorting);
		var t = (_c.sort || "name_asc").split("_");
		Q.sort.keys.includes(t[0]) || (t[0] = "name"), t[1] && ["asc", "desc"].includes(t[1]) || (t[1] = Q.sort.sorting[t[0]].order), t.join("_") !== _c.sort && (_c.sort = t.join("_")), e(t[0], t[1]);
		const i = _id("change-sort");
		i.innerHTML = `<button type="button" class="button-icon">${U.get_svg_icon("sort_" + Q.sort.sort + "_" + Q.sort.order)}</button><div class="dropdown-menu dropdown-menu-topbar"><span class="dropdown-header" data-lang="sort">${J.get("sort")}</span>${V(Q.sort.keys, (e => {
			let t = "shuffle" === e ? U.get_svg_icon(`sort_${e}_asc`) : U.get_svg_icon_multi_class("svg-icon svg-icon-sort", "chevron_down", "chevron_up") + U.get_svg_icon_multi(`sort_${e}_asc`, `sort_${e}_desc`);
			return `<button class="dropdown-item dropdown-item-sort${e === Q.sort.sort ? " active sort-" + Q.sort.order : ""}" data-action="${e}">${t + J.span(e)}</button>`
		}))}</div>`;
		const a = i.firstElementChild, n = (i.children[1], i.lastElementChild), o = _class("dropdown-item", n);

		function s(e, t) {
			if (_c.sort_dirs_first && e._values.is_dir !== t._values.is_dir) return (t._values.is_dir ? 1 : -1) * Q.sort.multi;
			if ("shuffle" === Q.sort.sort) return .5 - Math.random();
			var i = e._values[Q.sort.prop], a = t._values[Q.sort.prop];
			return "name" === Q.sort.sort || i === a ? c(e._values.basename, t._values.basename) : i > a ? 1 : -1
		}

		var l = {
			locale: function (e, t) {
				return r.compare(e, t) || l.basic(e, t)
			}, basic: function (e, t) {
				var i = e.toLowerCase(), a = t.toLowerCase();
				return i === a ? e > t ? 1 : -1 : i > a ? 1 : -1
			}
		}, r = new Intl.Collator(_c.sort_function && !["basic", "locale"].includes(_c.sort_function) ? _c.sort_function.trim() : void 0, {numeric: !0, sensitivity: "base"}), c = l["basic" === _c.sort_function ? "basic" : "locale"];

		function p(e, t, i) {
			let a = o[Q.sort.index], n = d[Q.sort.index];
			e && (a.classList.toggle("active", i), n && n.classList.toggle("sortbar-active", i)), (e || t) && (a.classList.toggle("sort-" + Q.sort.order, i), n && n.classList.toggle("sort-" + Q.sort.order, i))
		}

		U.set_sort = function (t) {
			if (t) {
				var i = t !== Q.sort.sort, n = i ? Q.sort.sorting[t].order : "asc" === Q.sort.order ? "desc" : "asc", o = n !== Q.sort.order;
				p(i, o, !1), e(t, n), a.innerHTML = U.get_svg_icon("sort_" + t + "_" + n), p(i, o, !0), U.set_config("sort", Q.sort.sort + "_" + Q.sort.order)
			}
			_c.debug && console.time("sort"), Q.list && Q.list.sort(Q.sort.prop, {order: Q.sort.order, sortFunction: s}), _c.debug && console.timeEnd("sort")
		}, U.dropdown(i, a, (function () {
			let e = Q.sort.index >= Q.sort.keys.length - 1 ? 0 : Q.sort.index + 1;
			4 !== e || o[4].offsetParent || (e = 0), U.set_sort(Q.sort.keys[e])
		})), m(n, U.set_sort), X.sortbar = _id("files-sortbar"), P(X.sortbar, "sortbar-" + _c.layout), X.sortbar.innerHTML = `<div class="sortbar-inner">${V(Q.sort.keys, (e => "shuffle" === e ? "" : `<div class="sortbar-item sortbar-${e}${e === Q.sort.sort ? " sortbar-active sort-" + Q.sort.order : ""}" data-action="${e}"><span data-lang="${e}" class="sortbar-item-text">${J.get(e)}</span>${U.get_svg_icon_multi_class("svg-icon svg-icon-sort", "chevron_down", "chevron_up")}</div>`))}</div>`;
		const d = X.sortbar.firstChild.children;
		C(X.sortbar, (function (e) {
			var t = e.target.closest("[data-action]");
			t && U.set_sort(t.dataset.action, e)
		}))
	})(), (() => {
		if (Q.topbar = {info: {}}, X.filter.placeholder = J.get("filter"), X.filter.title = Y.c_key + "F", le.hash(), X.filter.parentElement.insertAdjacentHTML("beforeend", `${U.get_svg_icon_class("search", "svg-icon filter-search-icon")}<button class="button-icon filter-reset" tabindex="-1">${U.get_svg_icon("close_thin")}</button>`), C(X.filter.parentElement.lastElementChild, (() => {
			X.filter.focus(), le.clear(!0)
		})), J.dropdown(), (() => {
			const e = t("theme", {themes: ["contrast", "light", "dark"], default: "contrast", button: !0, auto: !0});
			_c.theme = !!e.button && j.get("files:theme") || (e.auto && matchMedia("(prefers-color-scheme:dark)").matches ? "dark" : e.default), _c.theme && e.themes.includes(_c.theme) || (_c.theme = e.default);
			const i = document.documentElement.dataset;
			if (i.theme !== _c.theme && (i.theme = _c.theme, j.set("files:theme", _c.theme)), !e.button) return;
			let a = e.themes.indexOf(_c.theme);
			X.topbar_top.insertAdjacentHTML("beforeend", `<button class="button-icon" id="change-theme">${U.get_svg_icon_multi("theme_contrast", "theme_light", "theme_dark")}</button>`), C(X.topbar_top.lastElementChild, (() => {
				a++, a >= e.themes.length && (a = 0), _c.theme = e.themes[a], y(document.body, "no-transition", null, 10), i.theme = _c.theme, j.set("files:theme", _c.theme)
			}))
		})(), _c.has_login) {
			X.topbar_top.insertAdjacentHTML("beforeend", '<a href="' + location.href.split("?")[0] + '?logout=1" class="button-icon" id="logout"' + x("logout", !0) + ">" + U.get_svg_icon("logout") + "</a>");
			var e = X.topbar_top.lastElementChild;
			C(e, (t => {
				t.preventDefault(), ue.confirm.fire({title: J.get("logout"), text: J.get("logout") + "?", cancelButtonText: J.get("cancel"), confirmButtonText: J.get("logout")}).then((t => {
					t.isConfirmed && location.assign(e.href)
				}))
			}))
		}
		screenfull.isEnabled && (X.topbar_top.insertAdjacentHTML("beforeend", '<button class="button-icon" id="topbar-fullscreen">' + U.get_svg_icon_multi("expand", "collapse") + "</button>"), C(X.topbar_top.lastElementChild, (function () {
			screenfull.toggle()
		})), screenfull.on("change", (function () {
			document.documentElement.classList.toggle("is-fullscreen", screenfull.isFullscreen)
		}))), U.topbar_info = function (e, t) {
			X.topbar_info.className = "info-" + t, X.topbar_info.innerHTML = e
		}, U.topbar_info_search = function (e, t) {
			if (!e) return X.topbar_info.className = "info-hidden";
			X.topbar_info.classList.contains("info-search") ? (X.topbar_info.classList.toggle("info-nomatch", !t), X.topbar_info.children[0].textContent = t, X.topbar_info.children[2].textContent = e) : U.topbar_info('<span class="info-search-count">' + t + '</span><span class="info-search-lang"><span data-lang="matches found for">' + J.get("matches found for") + '</span></span><span class="info-search-phrase">' + e + '</span><button class="button-icon info-search-reset" data-action="reset">' + U.get_svg_icon("close_thin") + "</button>", "search" + (t ? "" : " info-nomatch"))
		}
	})(), _c.config.favicon && document.head.insertAdjacentHTML("beforeend", _c.config.favicon), "popup" === _c.click && Y.is_pointer && X.files_container.style.setProperty("--files-cursor", "zoom-in"), "IntersectionObserver" in window && "IntersectionObserverEntry" in window && "intersectionRatio" in window.IntersectionObserverEntry.prototype ? xe() : U.load_plugin("intersection-observer", xe, {src: ["intersection-observer@0.12.2/intersection-observer.js"]})
}("undefined" == typeof files ? files = {} : files);
