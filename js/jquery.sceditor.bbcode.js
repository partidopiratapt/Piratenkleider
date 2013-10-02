/* SCEditor v1.4.4 | (C) 2011-2013, Sam Clarke | sceditor.com/license */
!function(a, b, c) {
    "use strict";
    var d = {
        html: '<!DOCTYPE html><html><head><style>.ie * {min-height: auto !important}</style><meta http-equiv="Content-Type" content="text/html;charset={charset}" /><link rel="stylesheet" type="text/css" href="{style}" /></head><body contenteditable="true" {spellcheck}></body></html>', toolbarButton: '<a class="sceditor-button sceditor-button-{name}" data-sceditor-command="{name}" unselectable="on"><div unselectable="on">{dispName}</div></a>', emoticon: '<img src="{url}" data-sceditor-emoticon="{key}" alt="{key}" title="{tooltip}" />', fontOpt: '<a class="sceditor-font-option" href="#" data-font="{font}"><font face="{font}">{font}</font></a>', sizeOpt: '<a class="sceditor-fontsize-option" data-size="{size}" href="#"><font size="{size}">{size}</font></a>', pastetext: '<div><label for="txt">{label}</label> <textarea cols="20" rows="7" id="txt"></textarea></div><div><input type="button" class="button" value="{insert}" /></div>', table: '<div><label for="rows">{rows}</label><input type="text" id="rows" value="2" /></div><div><label for="cols">{cols}</label><input type="text" id="cols" value="2" /></div><div><input type="button" class="button" value="{insert}" /></div>', image: '<div><label for="link">{url}</label> <input type="text" id="image" value="http://" /></div><div><label for="width">{width}</label> <input type="text" id="width" size="2" /></div><div><label for="height">{height}</label> <input type="text" id="height" size="2" /></div><div><input type="button" class="button" value="{insert}" /></div>', email: '<div><label for="email">{label}</label> <input type="text" id="email" /></div><div><input type="button" class="button" value="{insert}" /></div>', link: '<div><label for="link">{url}</label> <input type="text" id="link" value="http://" /></div><div><label for="des">{desc}</label> <input type="text" id="des" /></div><div><input type="button" class="button" value="{ins}" /></div>', youtubeMenu: '<div><label for="link">{label}</label> <input type="text" id="link" value="http://" /></div><div><input type="button" class="button" value="{insert}" /></div>', youtube: '<iframe width="560" height="315" src="http://www.youtube.com/embed/{id}?wmode=opaque" data-youtube-id="{id}" frameborder="0" allowfullscreen></iframe>'}, e = function(b, c, e) {
        var f = d[b];
        return a.each(c, function(a, b) {
            f = f.replace(new RegExp("\\{" + a + "\\}", "g"), b)
        }), e && (f = a(f)), f
    };
    a.sceditor = function(d, f) {
        var g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z, A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T, U, V, W, X, Y, Z, $, _, ab, bb, cb, db, eb, fb, gb = this, hb = d.get ? d.get(0) : d, ib = a(hb), jb = [], kb = [], lb = [], mb = [], nb = {}, ob = [];
        gb.commands = a.extend(!0, {}, f.commands || a.sceditor.commands), gb.opts = f = a.extend({}, a.sceditor.defaultOptions, f), A = function() {
            ib.data("sceditor", gb), a.each(f, function(b, c) {
                a.isPlainObject(c) && (f[b] = a.extend(!0, {}, c))
            }), f.locale && "en" !== f.locale && G(), g = a('<div class="sceditor-container" />').insertAfter(ib).css("z-index", f.zIndex), a.sceditor.ie && g.addClass("ie ie" + a.sceditor.ie), y = !!ib.attr("required"), ib.removeAttr("required"), F(), M(), H(), E(), K(), I(), J(), a.sceditor.isWysiwygSupported || gb.toggleSourceMode();
            var d = function() {
                a(b).unbind("load", d), f.autofocus && cb(), f.autoExpand && gb.expandToContent(), X()
            };
            a(b).load(d), c.readyState && "complete" === c.readyState && d(), Z(), t.call("ready")
        }, F = function() {
            var b = f.plugins;
            b = b ? b.toString().split(",") : [], t = new a.sceditor.PluginManager(gb), a.each(b, function(b, c) {
                t.register(a.trim(c))
            })
        }, G = function() {
            var b;
            a.sceditor.locale[f.locale] ? q = a.sceditor.locale[f.locale] : (b = f.locale.split("-"), a.sceditor.locale[b[0]] && (q = a.sceditor.locale[b[0]])), q && q.dateFormat && (f.dateFormat = q.dateFormat)
        }, E = function() {
            var c, d;
            m = a("<textarea></textarea>").hide(), i = a('<iframe frameborder="0"></iframe>'), f.spellcheck || m.attr("spellcheck", "false"), "https:" === b.location.protocol && i.attr("src", "javascript:false"), g.append(i).append(m), j = i[0], n = m[0], gb.width(f.width || ib.width()), gb.height(f.height || ib.height()), c = N(), c.open(), c.write(e("html", {spellcheck: f.spellcheck ? "" : 'spellcheck="false"', charset: f.charset, style: f.style})), c.close(), l = a(c), k = a(c.body), gb.readOnly(!!f.readOnly), a.sceditor.ie && l.find("html").addClass("ie ie" + a.sceditor.ie), (a.sceditor.ios || a.sceditor.ie) && (k.height("100%"), a.sceditor.ie || k.bind("touchend", gb.focus)), r = new a.sceditor.rangeHelper(j.contentWindow), gb.val(ib.hide().val()), d = ib.attr("tabindex"), m.attr("tabindex", d), i.attr("tabindex", d)
        }, I = function() {
            f.autoUpdate && (k.bind("blur", gb.updateOriginal), m.bind("blur", gb.updateOriginal)), null === f.rtl && (f.rtl = "rtl" === m.css("direction")), gb.rtl(!!f.rtl), f.autoExpand && l.bind("keyup", gb.expandToContent), f.resizeEnabled && L(), g.attr("id", f.id), gb.emoticons(f.emoticonsEnabled)
        }, J = function() {
            a(c).click(W), a(hb.form).bind("reset", T).submit(gb.updateOriginal), a(b).bind("resize orientationChanged", X), k.keypress(S).keydown(Q).keydown(R).keyup(_).bind("paste", O).bind(a.sceditor.ie ? "selectionchange" : "keyup focus blur contextmenu mouseup touchend click", ab).bind("keydown keyup keypress focus blur contextmenu", V), f.emoticonsCompat && b.getSelection && k.keyup(eb), m.bind("keydown keyup keypress focus blur contextmenu", V).keydown(Q), l.keypress(S).mousedown(U).bind(a.sceditor.ie ? "selectionchange" : "focus blur contextmenu mouseup click", ab).bind("beforedeactivate keyup", D).keyup(_).focus(function() {
                p = null
            }), g.bind("selectionchanged", bb).bind("selectionchanged", Z).bind("selectionchanged", V).bind("nodechanged", V)
        }, H = function() {
            var b, c, d = (f.toolbarExclude || "").split(","), i = f.toolbar.split("|");
            h = a('<div class="sceditor-toolbar" unselectable="on" />'), a.each(i, function(f, g) {
                b = a('<div class="sceditor-group" />'), a.each(g.split(","), function(f, g) {
                    !gb.commands[g] || a.inArray(g, d) > -1 || (c = e("toolbarButton", {name: g, dispName: gb._(gb.commands[g].tooltip || g)}, !0), c.data("sceditor-txtmode", !!gb.commands[g].txtExec), c.data("sceditor-wysiwygmode", !!gb.commands[g].exec), c.click(function() {
                        var b = a(this);
                        return b.hasClass("disabled") || C(b, gb.commands[g]), Z(), !1
                    }), gb.commands[g].tooltip && c.attr("title", gb._(gb.commands[g].tooltip)), gb.commands[g].exec || c.addClass("disabled"), gb.commands[g].shortcut && gb.addShortcut(gb.commands[g].shortcut, g), b.append(c))
                }), b[0].firstChild && h.append(b)
            }), a(f.toolbarContainer || g).append(h)
        }, K = function() {
            a.each(gb.commands, function(b, c) {
                c.keyPress && jb.push(c.keyPress), c.forceNewLineAfter && a.isArray(c.forceNewLineAfter) && (lb = a.merge(lb, c.forceNewLineAfter)), c.state ? mb.push({name: b, state: c.state}) : "string" == typeof c.exec && mb.push({name: b, state: c.exec})
            }), _()
        }, L = function() {
            var d, e, h, i, j, k, l = a('<div class="sceditor-grip" />'), m = a('<div class="sceditor-resize-cover" />'), n = 0, o = 0, p = 0, q = 0, r = g.width(), s = g.height(), t = !1, u = gb.rtl();
            d = f.resizeMinHeight || s / 1.5, e = f.resizeMaxHeight || 2.5 * s, h = f.resizeMinWidth || r / 1.25, i = f.resizeMaxWidth || 1.25 * r, j = function(c) {
                "touchmove" === c.type && (c = b.event);
                var j = q + (c.pageY - o), k = u ? p - (c.pageX - n) : p + (c.pageX - n);
                i > 0 && k > i && (k = i), e > 0 && j > e && (j = e), (!f.resizeWidth || h > k || i > 0 && k > i) && (k = !1), (!f.resizeHeight || d > j || e > 0 && j > e) && (j = !1), (k || j) && (gb.dimensions(k, j), a.sceditor.ie < 7 && g.height(j)), c.preventDefault()
            }, k = function(b) {
                t && (t = !1, m.hide(), g.removeClass("resizing").height("auto"), a(c).unbind("touchmove mousemove", j), a(c).unbind("touchend mouseup", k), b.preventDefault())
            }, g.append(l), g.append(m.hide()), l.bind("touchstart mousedown", function(d) {
                "touchstart" === d.type && (d = b.event), n = d.pageX, o = d.pageY, p = g.width(), q = g.height(), t = !0, g.addClass("resizing"), m.show(), a(c).bind("touchmove mousemove", j), a(c).bind("touchend mouseup", k), a.sceditor.ie < 7 && g.height(q), d.preventDefault()
            })
        }, M = function() {
            var b, d = f.emoticons, e = f.emoticonsRoot;
            a.isPlainObject(d) && f.emoticonsEnabled && a.each(d, function(f, g) {
                a.each(g, function(a, g) {
                    e && (g = {url: e + (g.url || g), tooltip: g.tooltip || a}, d[f][a] = g), b = c.createElement("img"), b.src = g.url || g, kb.push(b)
                })
            })
        }, cb = function() {
            var b, c, d, e = l[0], h = k[0], i = !!f.autofocusEnd;
            if (g.is(":visible")) {
                if (gb.sourceMode())
                    d = n.value.length, n.setSelectionRange ? n.setSelectionRange(d, d) : n.createTextRange && (b = n.createTextRange(), b.moveEnd("character", d), b.moveStart("character", d), r.selectRange(b));
                else {
                    if (a.sceditor.dom.removeWhiteSpace(h), i)
                        for ((c = h.lastChild) || k.append(c = e.createElement("div")); c.lastChild; )
                            c = c.lastChild, /br/i.test(c.nodeName) && c.previousSibling && (c = c.previousSibling);
                    else
                        c = h.firstChild;
                    e.createRange ? (b = e.createRange(), /br/i.test(c.nodeName) ? b.setStartBefore(c) : b.selectNodeContents(c), b.collapse(!1)) : (b = h.createTextRange(), b.moveToElementText(3 !== c.nodeType ? c : c.parentNode), b.collapse(!1)), r.selectRange(b), i && (l.scrollTop(h.scrollHeight), k.scrollTop(h.scrollHeight))
                }
                gb.focus()
            }
        }, gb.readOnly = function(a) {
            return"boolean" != typeof a ? "readonly" === m.attr("readonly") : (k[0].contentEditable = !a, a ? m.attr("readonly", "readonly") : m.removeAttr("readonly"), Y(a), this)
        }, gb.rtl = function(a) {
            var b = a ? "rtl" : "ltr";
            return"boolean" != typeof a ? "rtl" === m.attr("dir") : (k.attr("dir", b), m.attr("dir", b), g.removeClass("rtl").removeClass("ltr").addClass(b), this)
        }, Y = function(b) {
            var c = gb.inSourceMode();
            h.find(".sceditor-button").removeClass("disabled").each(function() {
                var d = a(this);
                b === !0 || c && !d.data("sceditor-txtmode") ? d.addClass("disabled") : c || d.data("sceditor-wysiwygmode") || d.addClass("disabled")
            })
        }, gb.width = function(a, b) {
            return a || 0 === a ? (gb.dimensions(a, null, b), this) : g.width()
        }, gb.dimensions = function(b, d, e) {
            var j = a.sceditor.ie < 8 || c.documentMode < 8 ? 2 : 0;
            return b = b || 0 === b ? b : !1, d = d || 0 === d ? d : !1, b === !1 && d === !1 ? {width: gb.width(), height: gb.height()} : ("undefined" == typeof i.data("outerWidthOffset") && gb.updateStyleCache(), b !== !1 && (e !== !1 && (f.width = b), d === !1 && (d = g.height(), e = !1), g.width(b), b && b.toString().indexOf("%") > -1 && (b = g.width()), i.width(b - i.data("outerWidthOffset")), m.width(b - m.data("outerWidthOffset")), a.sceditor.ios && k && k.width(b - i.data("outerWidthOffset") - (k.outerWidth(!0) - k.width()))), d !== !1 && (e !== !1 && (f.height = d), d && d.toString().indexOf("%") > -1 && (d = g.height(d).height(), g.height("auto")), d -= f.toolbarContainer ? 0 : h.outerHeight(!0), i.height(d - i.data("outerHeightOffset")), m.height(d - j - m.data("outerHeightOffset"))), this)
        }, gb.updateStyleCache = function() {
            i.data("outerWidthOffset", i.outerWidth(!0) - i.width()), m.data("outerWidthOffset", m.outerWidth(!0) - m.width()), i.data("outerHeightOffset", i.outerHeight(!0) - i.height()), m.data("outerHeightOffset", m.outerHeight(!0) - m.height())
        }, gb.height = function(a, b) {
            return a || 0 === a ? (gb.dimensions(null, a, b), this) : g.height()
        }, gb.maximize = function(b) {
            return"undefined" == typeof b ? g.is(".sceditor-maximize") : (b = !!b, a.sceditor.ie < 7 && a("html, body").toggleClass("sceditor-maximize", b), g.toggleClass("sceditor-maximize", b), gb.width(b ? "100%" : f.width, !1), gb.height(b ? "100%" : f.height, !1), this)
        }, gb.expandToContent = function(a) {
            var b = g.height(), c = k[0].scrollHeight || l[0].documentElement.scrollHeight, d = b - i.height(), e = f.resizeMaxHeight || 2 * (f.height || ib.height());
            c += d, a !== !0 && c > e && (c = e), c > b && gb.height(c)
        }, gb.destroy = function() {
            t.destroy(), r = null, p = null, t = null, a(c).unbind("click", W), a(b).unbind("resize orientationChanged", X), a(hb.form).unbind("reset", T).unbind("submit", gb.updateOriginal), k.unbind(), l.unbind().find("*").remove(), m.unbind().remove(), h.remove(), g.unbind().find("*").unbind().remove(), g.remove(), ib.removeData("sceditor").removeData("sceditorbbcode").show(), y && ib.attr("required", "required")
        }, gb.createDropDown = function(b, c, d, e) {
            var g, h = o && o.is(".sceditor-" + c);
            gb.closeDropDown(), h || (e !== !1 && a(d).find(":not(input,textarea)").filter(function() {
                return 1 === this.nodeType
            }).attr("unselectable", "on"), g = {top: b.offset().top, left: b.offset().left, marginTop: b.outerHeight()}, a.extend(g, f.dropDownCss), o = a('<div class="sceditor-dropdown sceditor-' + c + '" />').css(g).append(d).appendTo(a("body")).click(function(a) {
                a.stopPropagation()
            }))
        }, W = function(a) {
            3 !== a.which && gb.closeDropDown()
        }, O = function(a) {
            var b, d, e = k[0], g = l[0], h = 0, i = c.createElement("div"), j = g.createDocumentFragment();
            if (f.disablePasting)
                return!1;
            if (f.enablePasteFiltering) {
                if (r.saveRange(), c.body.appendChild(i), a && a.clipboardData && a.clipboardData.getData && ((b = a.clipboardData.getData("text/html")) || (b = a.clipboardData.getData("text/plain"))))
                    return i.innerHTML = b, P(e, i), !1;
                for (; e.firstChild; )
                    j.appendChild(e.firstChild);
                return d = function(a, b) {
                    if (a.childNodes.length > 0) {
                        for (; a.firstChild; )
                            b.appendChild(a.firstChild);
                        for (; j.firstChild; )
                            a.appendChild(j.firstChild);
                        P(a, b)
                    } else {
                        if (h > 25) {
                            for (; j.firstChild; )
                                a.appendChild(j.firstChild);
                            return r.restoreRange(), void 0
                        }
                        ++h, setTimeout(function() {
                            d(a, b)
                        }, 20)
                    }
                }, d(e, i), gb.focus(), !0
            }
        }, P = function(b, c) {
            a.sceditor.dom.fixNesting(c);
            var d = c.innerHTML;
            t.hasHandler("toSource") && (d = t.callOnlyFirst("toSource", d, a(c))), c.parentNode.removeChild(c), t.hasHandler("toWysiwyg") && (d = t.callOnlyFirst("toWysiwyg", d, !0)), r.restoreRange(), gb.wysiwygEditorInsertHtml(d, null, !0)
        }, gb.closeDropDown = function(a) {
            o && (o.unbind().remove(), o = null), a === !0 && gb.focus()
        }, N = function() {
            return j.contentDocument ? j.contentDocument : j.contentWindow && j.contentWindow.document ? j.contentWindow.document : j.document ? j.document : null
        }, gb.wysiwygEditorInsertHtml = function(b, c, d) {
            var e, f, g = '<span id="sceditor-cursor">&nbsp;</span>';
            gb.focus(), (d || !a(v).is("code") && 0 === a(v).parents("code").length) && (c ? c += g : b += g, r.insertHTML(b, c), f = k.find("#sceditor-cursor"), e = f.offset().top + 2 * f.outerHeight(!0) - i.height(), f.remove(), l.scrollTop(e), k.scrollTop(e), r.saveRange(), B(k[0]), r.restoreRange(), _())
        }, gb.wysiwygEditorInsertText = function(b, c) {
            gb.wysiwygEditorInsertHtml(a.sceditor.escapeEntities(b), a.sceditor.escapeEntities(c))
        }, gb.insertText = function(a, b) {
            return gb.inSourceMode() ? gb.sourceEditorInsertText(a, b) : gb.wysiwygEditorInsertText(a, b), this
        }, gb.sourceEditorInsertText = function(a, b) {
            var d, e, f, g, h;
            h = n.scrollTop, n.focus(), "undefined" != typeof n.selectionStart ? (e = n.selectionStart, f = n.selectionEnd, g = a.length, b && (a += n.value.substring(e, f) + b), n.value = n.value.substring(0, e) + a + n.value.substring(f, n.value.length), n.selectionStart = e + a.length - (b ? b.length : 0), n.selectionEnd = n.selectionStart) : "undefined" != typeof c.selection.createRange ? (d = c.selection.createRange(), b && (a += d.text + b), d.text = a, b && d.moveEnd("character", 0 - b.length), d.moveStart("character", d.End - d.Start), d.select()) : n.value += a + b, n.scrollTop = h, n.focus()
        }, gb.getRangeHelper = function() {
            return r
        }, gb.val = function(a, b) {
            return"string" == typeof a ? (gb.inSourceMode() ? gb.setSourceEditorValue(a) : (b !== !1 && t.hasHandler("toWysiwyg") && (a = t.callOnlyFirst("toWysiwyg", a)), gb.setWysiwygEditorValue(a)), this) : gb.inSourceMode() ? gb.getSourceEditorValue(!1) : gb.getWysiwygEditorValue()
        }, gb.insert = function(b, c, d, e, f) {
            if (gb.inSourceMode())
                gb.sourceEditorInsertText(b, c);
            else {
                if (c) {
                    var g = gb.getRangeHelper().selectedHtml(), h = a("<div>").appendTo(a("body")).hide().html(g);
                    d !== !1 && t.hasHandler("toSource") && (g = t.callOnlyFirst("toSource", g, h)), h.remove(), b += g + c
                }
                d !== !1 && t.hasHandler("toWysiwyg") && (b = t.callOnlyFirst("toWysiwyg", b, !0)), d !== !1 && f === !0 && (b = b.replace(/&lt;/g, "<").replace(/&gt;/g, ">").replace(/&amp;/g, "&")), gb.wysiwygEditorInsertHtml(b)
            }
            return this
        }, gb.getWysiwygEditorValue = function(b) {
            var c, d, e = r.hasSelection();
            return e ? r.saveRange() : p && p.getBookmark && (d = p.getBookmark()), a.sceditor.dom.fixNesting(k[0]), c = k.html(), b !== !1 && t.hasHandler("toSource") && (c = t.callOnlyFirst("toSource", c, k)), e ? (r.restoreRange(), p = null) : d && (p.moveToBookmark(d), p = null), c
        }, gb.getBody = function() {
            return k
        }, gb.getContentAreaContainer = function() {
            return i
        }, gb.getSourceEditorValue = function(a) {
            var b = m.val();
            return a !== !1 && t.hasHandler("toWysiwyg") && (b = t.callOnlyFirst("toWysiwyg", b)), b
        }, gb.setWysiwygEditorValue = function(b) {
            b || (b = "<p>" + (a.sceditor.ie ? "" : "<br />") + "</p>"), k[0].innerHTML = b, B(k[0]), _()
        }, gb.setSourceEditorValue = function(a) {
            m.val(a)
        }, gb.updateOriginal = function() {
            ib.val(gb.val())
        }, B = function(b) {
            if (f.emoticonsEnabled && !a(b).parents("code").length) {
                var c = b.ownerDocument, d = [], g = [], h = a.extend({}, f.emoticons.more, f.emoticons.dropdown, f.emoticons.hidden);
                a.each(h, function(b) {
                    f.emoticonsCompat && (g[b] = new RegExp("(>|^|\\s| | | | |&nbsp;)" + a.sceditor.regexEscape(b) + "(\\s|$|<| | | | |&nbsp;)")), d.push(b)
                }), function i(b) {
                    for (b = b.firstChild; null != b; ) {
                        var j, k, l, m, n, o, p, q = b.parentNode, r = b.nodeValue;
                        if (3 !== b.nodeType)
                            a(b).is("code") || i(b);
                        else if (r)
                            for (n = d.length; n--; )
                                k = d[n], p = f.emoticonsCompat ? r.search(g[k]) : r.indexOf(k), p > -1 && (o = b.nextSibling, l = h[k], j = r.substr(p).split(k), r = r.substr(0, p) + j.shift(), b.nodeValue = r, m = a.sceditor.dom.parseHTML(e("emoticon", {key: k, url: l.url || l, tooltip: l.tooltip || k}), c), q.insertBefore(m[0], o), q.insertBefore(c.createTextNode(j.join(k)), o));
                        b = b.nextSibling
                    }
                }(b), f.emoticonsCompat && (ob = k.find("img[data-sceditor-emoticon]"))
            }
        }, gb.inSourceMode = function() {
            return g.hasClass("sourceMode")
        }, gb.sourceMode = function(a) {
            return"boolean" != typeof a ? gb.inSourceMode() : ((gb.inSourceMode() && !a || !gb.inSourceMode() && a) && gb.toggleSourceMode(), this)
        }, gb.toggleSourceMode = function() {
            (a.sceditor.isWysiwygSupported || !gb.inSourceMode()) && (gb.blur(), gb.inSourceMode() ? gb.setWysiwygEditorValue(gb.getSourceEditorValue()) : gb.setSourceEditorValue(gb.getWysiwygEditorValue()), p = null, m.toggle(), i.toggle(), gb.inSourceMode() ? g.removeClass("sourceMode").addClass("wysiwygMode") : g.removeClass("wysiwygMode").addClass("sourceMode"), Y(), Z())
        }, $ = function() {
            return n.focus(), null != n.selectionStart ? n.value.substring(n.selectionStart, n.selectionEnd) : c.selection.createRange ? c.selection.createRange().text : void 0
        }, C = function(b, c) {
            return gb.inSourceMode() ? (c.txtExec && (a.isArray(c.txtExec) ? gb.sourceEditorInsertText.apply(gb, c.txtExec) : c.txtExec.call(gb, b, $())), void 0) : (c.exec && (a.isFunction(c.exec) ? c.exec.call(gb, b) : gb.execCommand(c.exec, c.hasOwnProperty("execParam") ? c.execParam : null)), void 0)
        }, D = function() {
            a.sceditor.ie && (p = r.selectedRange())
        }, gb.execCommand = function(b, c) {
            var d = !1, e = a(r.parentNode());
            if (gb.focus(), !e.is("code") && 0 === e.parents("code").length) {
                try {
                    d = l[0].execCommand(b, !1, c)
                } catch (f) {
                }
                !d && gb.commands[b] && gb.commands[b].errorMessage && alert(gb._(gb.commands[b].errorMessage))
            }
        }, ab = function() {
            var b = function() {
                r && !r.compare(w) && (w = r.cloneSelected(), g.trigger(a.Event("selectionchanged"))), x = !1
            };
            x || (x = !0, a.sceditor.ie ? b() : setTimeout(b, 100))
        }, bb = function() {
            var b, c = r.parentNode();
            u !== c && (b = u, u = c, v = r.getFirstBlockParent(c), g.trigger(a.Event("nodechanged", {oldNode: b, newNode: u})))
        }, gb.currentNode = function() {
            return u
        }, gb.currentBlockNode = function() {
            return v
        }, Z = function(a) {
            var b, c, d, e, f, g = l[0], i = mb.length, j = gb.sourceMode();
            if (gb.sourceMode() || gb.readOnly())
                h.find(".sceditor-button").removeClass("active");
            else
                for (f = a?a.newNode:r.parentNode(), d = r.getFirstBlockParent(f); i--; )
                    if (b = 0, c = mb[i], e = h.find(".sceditor-button-" + c.name), j && !e.data("sceditor-txtmode"))
                        e.addClass("disabled");
                    else if (j || e.data("sceditor-wysiwygmode")) {
                        if ("string" == typeof c.state)
                            try {
                                b = g.queryCommandEnabled(c.state) ? 0 : -1, b > -1 && (b = g.queryCommandState(c.state) ? 1 : 0)
                            } catch (k) {
                            }
                        else
                            b = c.state.call(gb, f, d);
                        0 > b ? e.addClass("disabled") : e.removeClass("disabled"), b > 0 ? e.addClass("active") : e.removeClass("active")
                    } else
                        e.addClass("disabled")
        }, S = function(b) {
            var c, d = jb.length;
            if (gb.closeDropDown(), c = a(u), 13 === b.which && (c.is("code,blockquote,pre") || 0 !== c.parents("code,blockquote,pre").length))
                return p = null, gb.wysiwygEditorInsertHtml("<br />", null, !0), !1;
            if (!c.is("code") && 0 === c.parents("code").length)
                for (; d--; )
                    jb[d].call(gb, b, j, m)
        }, _ = function() {
            var b, c, d;
            a.sceditor.dom.rTraverse(k[0], function(e) {
                return b = e.nodeName.toLowerCase(), a.inArray(b, lb) > -1 && (c = !0), 3 === e.nodeType && !/^\s*$/.test(e.nodeValue) || "br" === b || a.sceditor.ie && !e.firstChild && !a.sceditor.dom.isInline(e, !1) ? (c && (d = k[0].ownerDocument.createElement("div"), d.className = "sceditor-nlf", d.innerHTML = a.sceditor.ie ? "" : "<br />", k[0].appendChild(d)), !1) : void 0
            })
        }, T = function() {
            gb.val(ib.val())
        }, U = function() {
            gb.closeDropDown(), p = null
        }, X = function() {
            var a = f.height, b = f.width;
            gb.maximize() ? gb.dimensions("100%", "100%", !1) : (a && a.toString().indexOf("%") > -1 && gb.height(a), b && b.toString().indexOf("%") > -1 && gb.width(b))
        }, gb._ = function() {
            var a = arguments;
            return q && q[a[0]] && (a[0] = q[a[0]]), a[0].replace(/\{(\d+)\}/g, function(b, c) {
                return"undefined" != typeof a[c - 0 + 1] ? a[c - 0 + 1] : "{" + c + "}"
            })
        }, V = function(b) {
            var c, d = a.extend({}, b);
            t.call(d.type + "Event", b, gb), delete d.type, c = a.Event((b.target === n ? "scesrc" : "scewys") + b.type, d), g.trigger.apply(g, [c, gb]), c.isDefaultPrevented() && b.preventDefault(), c.isImmediatePropagationStopped() && c.stopImmediatePropagation(), c.isPropagationStopped() && c.stopPropagation()
        }, gb.bind = function(b, c, d, e) {
            var f = b.length;
            for (b = b.split(" "); f--; )
                a.isFunction(c) && (d || g.bind("scewys" + b[f], c), e || g.bind("scesrc" + b[f], c));
            return this
        }, gb.unbind = function(b, c, d, e) {
            var f = b.length;
            for (b = b.split(" "); f--; )
                a.isFunction(c) && (d || g.unbind("scewys" + b[f], c), e || g.unbind("scesrc" + b[f], c));
            return this
        }, gb.blur = function(b, c, d) {
            return a.isFunction(b) ? gb.bind("blur", b, c, d) : gb.sourceMode() ? m.blur() : (s || (s = a('<input style="position:absolute;width:0;height:0;opacity:0;border:0;padding:0;filter:alpha(opacity=0)" type="text" />').appendTo(g)), s.removeAttr("disabled").show().focus().blur().hide().attr("disabled", "disabled")), this
        }, gb.focus = function(b, c, d) {
            return a.isFunction(b) ? gb.bind("focus", b, c, d) : gb.inSourceMode() ? n.focus() : (j.contentWindow.focus(), k[0].focus(), p && (r.selectRange(p), p = null)), this
        }, gb.keyDown = function(a, b, c) {
            return gb.bind("keydown", a, b, c)
        }, gb.keyPress = function(a, b, c) {
            return gb.bind("keypress", a, b, c)
        }, gb.keyUp = function(a, b, c) {
            return gb.bind("keyup", a, b, c)
        }, gb.nodeChanged = function(a) {
            return gb.bind("nodechanged", a, !1, !0)
        }, gb.selectionChanged = function(a) {
            return gb.bind("selectionchanged", a, !1, !0)
        }, db = function(b) {
            var c = 0, d = String.fromCharCode(b.which);
            if (!a(v).is("code") && !a(v).parents("code").length)
                return gb.emoticonsCache || (gb.emoticonsCache = [], a.each(a.extend({}, f.emoticons.more, f.emoticons.dropdown, f.emoticons.hidden), function(a, b) {
                    gb.emoticonsCache[c++] = [a, e("emoticon", {key: a, url: b.url || b, tooltip: b.tooltip || a})]
                }), gb.emoticonsCache.sort(function(a, b) {
                    return a[0].length - b[0].length
                }), gb.longestEmoticonCode = gb.emoticonsCache[gb.emoticonsCache.length - 1][0].length), gb.getRangeHelper().raplaceKeyword(gb.emoticonsCache, !0, !0, gb.longestEmoticonCode, f.emoticonsCompat, d) ? (f.emoticonsCompat && (ob = k.find("img[data-sceditor-emoticon]")), /^\s$/.test(d) && f.emoticonsCompat) : void 0
        }, eb = function() {
            if (ob.length) {
                var b, c, d, e, f, g, h = gb.currentBlockNode(), i = !1, j = /[^\s\xA0\u2002\u2003\u2009]+/;
                ob = a.map(ob, function(k) {
                    return k && k.parentNode ? a.contains(h, k) ? (b = k.previousSibling, c = k.nextSibling, f = b.nodeValue, null === f && (f = b.innerText || ""), b && j.test(b.nodeValue.slice(-1)) || c && j.test((c.nodeValue || "")[0]) ? (d = k.parentNode, e = r.cloneSelected(), g = e.startContainer, f += a(k).data("sceditor-emoticon"), g === c ? i = f.length + e.startOffset : g === h && h.childNodes[e.startOffset] === c ? i = f.length : g === b && (i = e.startOffset), c && 3 === c.nodeType || (c = d.insertBefore(d.ownerDocument.createTextNode(""), c)), c.insertData(0, f), d.removeChild(b), d.removeChild(k), i !== !1 && (e.setStart(c, i), e.collapse(!0), r.selectRange(e)), null) : k) : k : null
                })
            }
        }, gb.emoticons = function(b) {
            return b || b === !1 ? (f.emoticonsEnabled = b, b ? (k.keypress(db), gb.sourceMode() || (r.saveRange(), B(k[0]), ob = k.find("img[data-sceditor-emoticon]"), r.restoreRange())) : (k.find("img[data-sceditor-emoticon]").replaceWith(function() {
                return a(this).data("sceditor-emoticon")
            }), ob = [], k.unbind("keypress", db)), this) : f.emoticonsEnabled
        }, gb.css = function(b) {
            return z || (z = a('<style id="#inline" />').appendTo(l.find("head"))[0]), "string" != typeof b ? z.styleSheet ? z.styleSheet.cssText : z.innerHTML : (z.styleSheet ? z.styleSheet.cssText = b : z.innerHTML = b, this)
        }, Q = function(a) {
            var b = [], c = {"`": "~", 1: "!", 2: "@", 3: "#", 4: "$", 5: "%", 6: "^", 7: "&", 8: "*", 9: "(", 0: ")", "-": "_", "=": "+", ";": ":", "'": '"', ",": "<", ".": ">", "/": "?", "\\": "|", "[": "{", "]": "}"}, d = {8: "backspace", 9: "tab", 13: "enter", 19: "pause", 20: "capslock", 27: "esc", 32: "space", 33: "pageup", 34: "pagedown", 35: "end", 36: "home", 37: "left", 38: "up", 39: "right", 40: "down", 45: "insert", 46: "del", 91: "win", 92: "win", 93: "select", 96: "0", 97: "1", 98: "2", 99: "3", 100: "4", 101: "5", 102: "6", 103: "7", 104: "8", 105: "9", 106: "*", 107: "+", 109: "-", 110: ".", 111: "/", 112: "f1", 113: "f2", 114: "f3", 115: "f4", 116: "f5", 117: "f6", 118: "f7", 119: "f8", 120: "f9", 121: "f10", 122: "f11", 123: "f12", 144: "numlock", 145: "scrolllock", 186: ";", 187: "=", 188: ",", 189: "-", 190: ".", 191: "/", 192: "`", 219: "[", 220: "\\", 221: "]", 222: "'"}, e = {109: "-", 110: "del", 111: "/", 96: "0", 97: "1", 98: "2", 99: "3", 100: "4", 101: "5", 102: "6", 103: "7", 104: "8", 105: "9"}, f = a.which, g = d[f] || String.fromCharCode(f).toLowerCase();
            return a.ctrlKey && b.push("ctrl"), a.altKey && b.push("alt"), a.shiftKey && (b.push("shift"), e[f] ? g = e[f] : c[g] && (g = c[g])), g && (16 > f || f > 18) && b.push(g), b = b.join("+"), nb[b] ? nb[b].call(gb) : void 0
        }, gb.addShortcut = function(a, b) {
            return a = a.toLowerCase(), nb[a] = "string" == typeof b ? function() {
                return C(h.find(".sceditor-button-" + b), gb.commands[b]), !1
            } : b, this
        }, gb.removeShortcut = function(a) {
            return delete nb[a.toLowerCase()], this
        }, R = function(c) {
            var d, e, g, h, i;
            if (!a.sceditor.ie && !f.disableBlockRemove && 8 === c.which && (h = r.selectedRange()) && (b.getSelection ? (d = h.startContainer, e = h.startOffset) : (d = h.parentElement(), g = l[0].selection.createRange(), g.moveToElementText(d), g.setEndPoint("EndToStart", h), e = g.text.length), 0 === e && (i = fb()))) {
                for (; d !== i; ) {
                    for (; d.previousSibling; )
                        if (d = d.previousSibling, 3 !== d.nodeType || d.nodeValue)
                            return;
                    if (!(d = d.parentNode))
                        return
                }
                if (i && !a(i).is("body"))
                    return gb.clearBlockFormatting(i), !1
            }
        }, fb = function() {
            for (var b = v; !a.sceditor.dom.hasStyling(b); )
                if (!(b = b.parentNode) || a(b).is("body"))
                    return;
            return b
        }, gb.clearBlockFormatting = function(b) {
            return b = b || fb(), !b || a(b).is("body") ? this : (r.saveRange(), p = null, b.className = "", a(b).attr("style", ""), a(b).is("p,div") || a.sceditor.dom.convertElement(b, "p"), r.restoreRange(), this)
        }, A()
    }, a.sceditor.ie = function() {
        var a, d = 3, e = c.createElement("div"), f = e.getElementsByTagName("i");
        do
            e.innerHTML = "<!--[if gt IE " + ++d + "]><i></i><![endif]-->";
        while (f[0]);
        return c.documentMode && c.all && b.atob && (d = 10), 4 === d && c.documentMode && (d = 11), d > 4 ? d : a
    }(), a.sceditor.ios = /iPhone|iPod|iPad| wosbrowser\//i.test(navigator.userAgent), a.sceditor.isWysiwygSupported = function() {
        var b, c, d = a('<div contenteditable="true">')[0].contentEditable, e = "undefined" != typeof d && "inherit" !== d, f = navigator.userAgent;
        return e ? (c = /Opera Mobi|Opera Mini/i.test(f), /Android/i.test(f) && (c = !0, /Safari/.test(f) && (b = /Safari\/(\d+)/.exec(f), c = b && b[1] ? b[1] < 534 : !0)), / Silk\//i.test(f) && (b = /AppleWebKit\/(\d+)/.exec(f), c = b && b[1] ? b[1] < 534 : !0), a.sceditor.ios && (c = !/OS [5-9](_\d)+ like Mac OS X/i.test(f)), /fennec/i.test(f) && (c = !1), /OneBrowser/i.test(f) && (c = !1), "UCWEB" === navigator.vendor && (c = !1), !c) : !1
    }(), a.sceditor.regexEscape = function(a) {
        return a.replace(/[\$\?\[\]\.\*\(\)\|\\]/g, "\\$&")
    }, a.sceditor.escapeEntities = function(a) {
        return a ? a.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/ {2}/g, " &nbsp;").replace(/\r\n|\r/g, "\n").replace(/\n/g, "<br />") : a
    }, a.sceditor.locale = {}, a.sceditor.commands = {bold: {exec: "bold", tooltip: "Bold", shortcut: "ctrl+b"}, italic: {exec: "italic", tooltip: "Italic", shortcut: "ctrl+i"}, underline: {exec: "underline", tooltip: "Underline", shortcut: "ctrl+u"}, strike: {exec: "strikethrough", tooltip: "Strikethrough"}, subscript: {exec: "subscript", tooltip: "Subscript"}, superscript: {exec: "superscript", tooltip: "Superscript"}, left: {exec: "justifyleft", tooltip: "Align left"}, center: {exec: "justifycenter", tooltip: "Center"}, right: {exec: "justifyright", tooltip: "Align right"}, justify: {exec: "justifyfull", tooltip: "Justify"}, font: {_dropDown: function(b, c, d) {
                for (var f = b.opts.fonts.split(","), g = a("<div />"), h = function() {
                    return d(a(this).data("font")), b.closeDropDown(!0), !1
                }, i = 0; i < f.length; i++)
                    g.append(e("fontOpt", {font: f[i]}, !0).click(h));
                b.createDropDown(c, "font-picker", g)
            }, exec: function(b) {
                var c = this;
                a.sceditor.command.get("font")._dropDown(c, b, function(a) {
                    c.execCommand("fontname", a)
                })
            }, tooltip: "Font Name"}, size: {_dropDown: function(b, c, d) {
                for (var f = a("<div />"), g = function(c) {
                    d(a(this).data("size")), b.closeDropDown(!0), c.preventDefault()
                }, h = 1; 7 >= h; h++)
                    f.append(e("sizeOpt", {size: h}, !0).click(g));
                b.createDropDown(c, "fontsize-picker", f)
            }, exec: function(b) {
                var c = this;
                a.sceditor.command.get("size")._dropDown(c, b, function(a) {
                    c.execCommand("fontsize", a)
                })
            }, tooltip: "Font Size"}, color: {_dropDown: function(b, c, d) {
                var e, f, g, h, i = {r: 255, g: 255, b: 255}, j = a("<div />"), k = b.opts.colors ? b.opts.colors.split("|") : new Array(21), l = [], m = a.sceditor.command.get("color");
                if (!m._htmlCache) {
                    for (e = 0; e < k.length; ++e) {
                        for (h = k[e]?k[e].split(","):new Array(21), l.push('<div class="sceditor-color-column">'), f = 0; f < h.length; ++f)
                            g = h[f] || "#" + i.r.toString(16) + i.g.toString(16) + i.b.toString(16), l.push('<a href="#" class="sceditor-color-option" style="background-color: ' + g + '" data-color="' + g + '"></a>'), 0 === f % 5 ? (i.g -= 51, i.b = 255) : i.b -= 51;
                        l.push("</div>"), 0 === e % 5 ? (i.r -= 51, i.g = 255, i.b = 255) : (i.g = 255, i.b = 255)
                    }
                    m._htmlCache = l.join("")
                }
                j.append(m._htmlCache).find("a").click(function(c) {
                    d(a(this).attr("data-color")), b.closeDropDown(!0), c.preventDefault()
                }), b.createDropDown(c, "color-picker", j)
            }, exec: function(b) {
                var c = this;
                a.sceditor.command.get("color")._dropDown(c, b, function(a) {
                    c.execCommand("forecolor", a)
                })
            }, tooltip: "Font Color"}, removeformat: {exec: "removeformat", tooltip: "Remove Formatting"}, cut: {exec: "cut", tooltip: "Cut", errorMessage: "Your browser does not allow the cut command. Please use the keyboard shortcut Ctrl/Cmd-X"}, copy: {exec: "copy", tooltip: "Copy", errorMessage: "Your browser does not allow the copy command. Please use the keyboard shortcut Ctrl/Cmd-C"}, paste: {exec: "paste", tooltip: "Paste", errorMessage: "Your browser does not allow the paste command. Please use the keyboard shortcut Ctrl/Cmd-V"}, pastetext: {exec: function(a) {
                var b, c = this, d = e("pastetext", {label: c._("Paste your text inside the following box:"), insert: c._("Insert")}, !0);
                d.find(".button").click(function(a) {
                    b = d.find("#txt").val(), b && c.wysiwygEditorInsertText(b), c.closeDropDown(!0), a.preventDefault()
                }), c.createDropDown(a, "pastetext", d)
            }, tooltip: "Paste Text"}, bulletlist: {exec: "insertunorderedlist", tooltip: "Bullet list"}, orderedlist: {exec: "insertorderedlist", tooltip: "Numbered list"}, table: {exec: function(b) {
                var c = this, d = e("table", {rows: c._("Rows:"), cols: c._("Cols:"), insert: c._("Insert")}, !0);
                d.find(".button").click(function(b) {
                    var e = d.find("#rows").val() - 0, f = d.find("#cols").val() - 0, g = "<table>";
                    if (!(1 > e || 1 > f)) {
                        for (var h = 0; e > h; h++) {
                            g += "<tr>";
                            for (var i = 0; f > i; i++)
                                g += "<td>" + (a.sceditor.ie ? "" : "<br />") + "</td>";
                            g += "</tr>"
                        }
                        g += "</table>", c.wysiwygEditorInsertHtml(g), c.closeDropDown(!0), b.preventDefault()
                    }
                }), c.createDropDown(b, "inserttable", d)
            }, tooltip: "Insert a table"}, horizontalrule: {exec: "inserthorizontalrule", tooltip: "Insert a horizontal rule"}, code: {forceNewLineAfter: ["code"], exec: function() {
                this.wysiwygEditorInsertHtml("<code>", "<br /></code>")
            }, tooltip: "Code"}, image: {exec: function(a) {
                var b = this, c = e("image", {url: b._("URL:"), width: b._("Width (optional):"), height: b._("Height (optional):"), insert: b._("Insert")}, !0);
                c.find(".button").click(function(a) {
                    var d = c.find("#image").val(), e = c.find("#width").val(), f = c.find("#height").val(), g = "";
                    e && (g += ' width="' + e + '"'), f && (g += ' height="' + f + '"'), d && "http://" !== d && b.wysiwygEditorInsertHtml("<img" + g + ' src="' + d + '" />'), b.closeDropDown(!0), a.preventDefault()
                }), b.createDropDown(a, "insertimage", c)
            }, tooltip: "Insert an image"}, email: {exec: function(a) {
                var b = this, c = e("email", {label: b._("E-mail:"), insert: b._("Insert")}, !0);
                c.find(".button").click(function(a) {
                    var d = c.find("#email").val();
                    d && (b.focus(), b.getRangeHelper().selectedHtml() ? b.execCommand("createlink", "mailto:" + d) : b.wysiwygEditorInsertHtml('<a href="mailto:' + d + '">' + d + "</a>")), b.closeDropDown(!0), a.preventDefault()
                }), b.createDropDown(a, "insertemail", c)
            }, tooltip: "Insert an email"}, link: {exec: function(a) {
                var b = this, c = e("link", {url: b._("URL:"), desc: b._("Description (optional):"), ins: b._("Insert")}, !0);
                c.find(".button").click(function(a) {
                    var d = c.find("#link").val(), e = c.find("#des").val();
                    d && "http://" !== d && (b.focus(), !b.getRangeHelper().selectedHtml() || e ? (e || (e = d), b.wysiwygEditorInsertHtml('<a href="' + d + '">' + e + "</a>")) : b.execCommand("createlink", d)), b.closeDropDown(!0), a.preventDefault()
                }), b.createDropDown(a, "insertlink", c)
            }, tooltip: "Insert a link"}, unlink: {state: function() {
                var b = a(this.currentNode());
                return b.is("a") || b.parents("a").length > 0 ? 0 : -1
            }, exec: function() {
                var b = a(this.currentNode()), c = b.is("a") ? b : b.parents("a").first();
                c.length && c.replaceWith(c.contents())
            }, tooltip: "Unlink"}, quote: {forceNewLineAfter: ["blockquote"], exec: function(b, c, d) {
                var e = "<blockquote>", f = "</blockquote>";
                c ? (d = d ? "<cite>" + d + "</cite>" : "", e = e + d + c + f, f = null) : "" === this.getRangeHelper().selectedHtml() && (f = a.sceditor.ie ? "" : "<br />" + f), this.wysiwygEditorInsertHtml(e, f)
            }, tooltip: "Insert a Quote"}, emoticon: {exec: function(b) {
                var c = this, d = function(e) {
                    var f = c.opts.emoticonsCompat, g = c.getRangeHelper(), h = f && " " !== g.getOuterText(!0, 1) ? " " : "", i = f && " " !== g.getOuterText(!1, 1) ? " " : "", j = a("<div />"), k = a("<div />").appendTo(j), l = a.extend({}, c.opts.emoticons.dropdown, e ? c.opts.emoticons.more : {}), m = 0;
                    return a.each(l, function() {
                        m++
                    }), m = Math.sqrt(m), a.each(l, function(b, d) {
                        k.append(a("<img />").attr({src: d.url || d, alt: b, title: d.tooltip || b}).click(function() {
                            return c.insert(h + a(this).attr("alt") + i, null, !1).closeDropDown(!0), !1
                        })), k.children().length >= m && (k = a("<div />").appendTo(j))
                    }), e || j.append(a(c._('<a class="sceditor-more">{0}</a>', c._("More"))).click(function() {
                        return c.createDropDown(b, "more-emoticons", d(!0)), !1
                    })), j
                };
                c.createDropDown(b, "emoticons", d(!1))
            }, txtExec: function(b) {
                a.sceditor.command.get("emoticon").exec.call(this, b)
            }, tooltip: "Insert an emoticon"}, youtube: {_dropDown: function(a, b, c) {
                var d, f = e("youtubeMenu", {label: a._("Video URL:"), insert: a._("Insert")}, !0);
                f.find(".button").click(function(b) {
                    var e = f.find("#link").val().replace("http://", "");
                    "" !== e && (d = e.match(/(?:v=|v\/|embed\/|youtu.be\/)(.{11})/), d && (e = d[1]), /^[a-zA-Z0-9_\-]{11}$/.test(e) ? c(e) : alert("Invalid YouTube video")), a.closeDropDown(!0), b.preventDefault()
                }), a.createDropDown(b, "insertlink", f)
            }, exec: function(b) {
                var c = this;
                a.sceditor.command.get("youtube")._dropDown(c, b, function(a) {
                    c.wysiwygEditorInsertHtml(e("youtube", {id: a}))
                })
            }, tooltip: "Insert a YouTube video"}, date: {_date: function(a) {
                var b = new Date, c = b.getYear(), d = b.getMonth() + 1, e = b.getDate();
                return 2e3 > c && (c = 1900 + c), 10 > d && (d = "0" + d), 10 > e && (e = "0" + e), a.opts.dateFormat.replace(/year/i, c).replace(/month/i, d).replace(/day/i, e)
            }, exec: function() {
                this.insertText(a.sceditor.command.get("date")._date(this))
            }, txtExec: function() {
                this.insertText(a.sceditor.command.get("date")._date(this))
            }, tooltip: "Insert current date"}, time: {_time: function() {
                var a = new Date, b = a.getHours(), c = a.getMinutes(), d = a.getSeconds();
                return 10 > b && (b = "0" + b), 10 > c && (c = "0" + c), 10 > d && (d = "0" + d), b + ":" + c + ":" + d
            }, exec: function() {
                this.insertText(a.sceditor.command.get("time")._time())
            }, txtExec: function() {
                this.insertText(a.sceditor.command.get("time")._time())
            }, tooltip: "Insert current time"}, ltr: {state: function(a, b) {
                return b && "ltr" === b.style.direction
            }, exec: function() {
                var b = this, c = b.getRangeHelper().getFirstBlockParent(), d = a(c);
                b.focus(), (c && !d.is("body") || (b.execCommand("formatBlock", "p"), c = b.getRangeHelper().getFirstBlockParent(), d = a(c), c && !d.is("body"))) && ("ltr" === d.css("direction") ? d.css("direction", "") : d.css("direction", "ltr"))
            }, tooltip: "Left-to-Right"}, rtl: {state: function(a, b) {
                return b && "rtl" === b.style.direction
            }, exec: function() {
                var b = this, c = b.getRangeHelper().getFirstBlockParent(), d = a(c);
                b.focus(), (c && !d.is("body") || (b.execCommand("formatBlock", "p"), c = b.getRangeHelper().getFirstBlockParent(), d = a(c), c && !d.is("body"))) && ("rtl" === d.css("direction") ? d.css("direction", "") : d.css("direction", "rtl"))
            }, tooltip: "Right-to-Left"}, print: {exec: "print", tooltip: "Print"}, maximize: {state: function() {
                return this.maximize()
            }, exec: function() {
                this.maximize(!this.maximize())
            }, txtExec: function() {
                this.maximize(!this.maximize())
            }, tooltip: "Maximize", shortcut: "ctrl+shift+m"}, source: {exec: function() {
                this.toggleSourceMode()
            }, txtExec: function() {
                this.toggleSourceMode()
            }, tooltip: "View source", shortcut: "ctrl+shift+s"}, ignore: {}}, a.sceditor.rangeHelper = function(b, c) {
        var d, e, f, g, h, i = !0, j = "sceditor-start-marker", k = "sceditor-end-marker", l = "character", m = this;
        f = function(a, b) {
            e = b || a.contentDocument || a.document, d = a, i = !!a.getSelection
        }(b, c), m.insertHTML = function(a, b) {
            var c, d, f = m.selectedRange();
            if (b && (a += m.selectedHtml() + b), i) {
                for (d = e.createElement("div"), c = e.createDocumentFragment(), d.innerHTML = a; d.firstChild; )
                    c.appendChild(d.firstChild);
                m.insertNode(c)
            } else {
                if (!f)
                    return!1;
                f.pasteHTML(a)
            }
        }, m.insertNode = function(a, b) {
            if (i) {
                var c, d, f = e.createDocumentFragment(), g = m.selectedRange();
                if (!g)
                    return!1;
                if (f.appendChild(a), b && (f.appendChild(g.extractContents()), f.appendChild(b)), d = f.lastChild, !d)
                    return;
                g.deleteContents(), g.insertNode(f), c = e.createRange(), c.setStartAfter(d), m.selectRange(c)
            } else
                m.insertHTML(a.outerHTML, b ? b.outerHTML : null)
        }, m.cloneSelected = function() {
            var a = m.selectedRange();
            return a ? i ? a.cloneRange() : a.duplicate() : void 0
        }, m.selectedRange = function() {
            var a, b, c = i ? d.getSelection() : e.selection;
            if (c) {
                if (c.getRangeAt && c.rangeCount <= 0) {
                    for (b = e.body; b.firstChild; )
                        b = b.firstChild;
                    a = e.createRange(), a.setStart(b, 0), c.addRange(a)
                }
                return i && (a = c.getRangeAt(0)), i || "Control" === c.type || (a = c.createRange()), h(a) ? a : null
            }
        }, h = function(a) {
            var b;
            return a && a.parentElement && (b = a.parentElement()) ? b.ownerDocument === e : !0
        }, m.hasSelection = function() {
            var a, b = i ? d.getSelection() : e.selection;
            return i || !b ? b && b.rangeCount > 0 : (a = b.createRange(), a && h(a))
        }, m.selectedHtml = function() {
            var a, b = m.selectedRange();
            return b ? !i && "" !== b.text && b.htmlText ? b.htmlText : i ? (a = e.createElement("div"), a.appendChild(b.cloneContents()), a.innerHTML) : "" : ""
        }, m.parentNode = function() {
            var a = m.selectedRange();
            return a ? a.parentElement ? a.parentElement() : a.commonAncestorContainer : void 0
        }, m.getFirstBlockParent = function(b) {
            var c = function(b) {
                return a.sceditor.dom.isInline(b, !0) ? (b = b ? b.parentNode : null, b ? c(b) : null) : b
            };
            return c(b || m.parentNode())
        }, m.insertNodeAt = function(a, b) {
            var c = m.selectedRange(), d = m.cloneSelected();
            return d ? (d.collapse(a), d.insertNode ? d.insertNode(b) : d.pasteHTML(b.outerHTML), m.selectRange(c), void 0) : !1
        }, g = function(a) {
            m.removeMarker(a);
            var b = e.createElement("span");
            return b.id = a, b.style.lineHeight = "0", b.style.display = "none", b.className = "sceditor-selection sceditor-ignore", b.innerHTML = " ", b
        }, m.insertMarkers = function() {
            m.insertNodeAt(!0, g(j)), m.insertNodeAt(!1, g(k))
        }, m.getMarker = function(a) {
            return e.getElementById(a)
        }, m.removeMarker = function(a) {
            var b = m.getMarker(a);
            b && b.parentNode.removeChild(b)
        }, m.removeMarkers = function() {
            m.removeMarker(j), m.removeMarker(k)
        }, m.saveRange = function() {
            m.insertMarkers()
        }, m.selectRange = function(a) {
            i ? (d.getSelection().removeAllRanges(), d.getSelection().addRange(a)) : a.select()
        }, m.restoreRange = function() {
            var a, b = m.selectedRange(), c = m.getMarker(j), d = m.getMarker(k);
            return c && d && b ? (i ? (b = e.createRange(), b.setStartBefore(c), b.setEndAfter(d), m.selectRange(b)) : (b = e.body.createTextRange(), a = e.body.createTextRange(), a.moveToElementText(c), b.setEndPoint("StartToStart", a), b.moveStart(l, 0), a.moveToElementText(d), b.setEndPoint("EndToStart", a), b.moveEnd(l, 0), m.selectRange(b)), m.removeMarkers(), void 0) : !1
        }, m.selectOuterText = function(a, b) {
            var c = m.cloneSelected();
            return c ? (c.collapse(!1), i ? (c.setStart(c.startContainer, c.startOffset - a), c.setEnd(c.endContainer, c.endOffset + b)) : (c.moveStart(l, 0 - a), c.moveEnd(l, b)), m.selectRange(c), void 0) : !1
        }, m.getOuterText = function(a, b) {
            var c = "", d = m.cloneSelected();
            return d ? (d.collapse(!1), a ? i ? (c = d.startContainer.textContent.substr(0, d.startOffset), c = c.substr(Math.max(0, c.length - b))) : (d.moveStart(l, 0 - b), c = d.text) : i ? c = d.startContainer.textContent.substr(d.startOffset, b) : (d.moveEnd(l, b), c = d.text), c) : ""
        }, m.raplaceKeyword = function(b, c, d, e, f, g) {
            d || b.sort(function(a, b) {
                return a.length - b.length
            });
            var h, j, k, l, n, o, p, q = b.length, r = e || b[q - 1][0].length;
            if (f) {
                if (!i)
                    return!1;
                ++r
            }
            for (h = m.getOuterText(!0, r), j = h + (null != g?g:""), c && (j += m.getOuterText(!1, r)); q--; )
                if (p = b[q][0], n = new RegExp("(?:[\\s    ])" + a.sceditor.regexEscape(p) + "(?=[\\s    ])"), o = h.length - 1 - p.length, f && --o, o = Math.max(0, o), (k = f ? j.substr(o).search(n) : j.indexOf(p, o)) > -1) {
                    if (f && (k += o + 1), k > h.length || k + p.length + (f ? 1 : 0) < h.length)
                        continue;
                    return l = h.length - k, m.selectOuterText(l, p.length - l - (null != g && /^\S/.test(g) ? 1 : 0)), m.insertHTML(b[q][1]), !0
                }
            return!1
        }, m.compare = function(a, b) {
            return b || (b = m.selectedRange()), a && b ? i ? 0 === a.compareBoundaryPoints(Range.END_TO_END, b) && 0 === a.compareBoundaryPoints(Range.START_TO_START, b) : h(a) && h(b) && 0 === a.compareEndPoints("EndToEnd", b) && 0 === a.compareEndPoints("StartToStart", b) : !a && !b
        }
    }, a.sceditor.dom = {traverse: function(a, b, c, d, e) {
            if (a)
                for (a = e ? a.lastChild : a.firstChild; null != a; ) {
                    var f = e ? a.previousSibling : a.nextSibling;
                    if (!c && b(a) === !1)
                        return!1;
                    if (!d && this.traverse(a, b, c, d, e) === !1)
                        return!1;
                    if (c && b(a) === !1)
                        return!1;
                    a = f
                }
        }, rTraverse: function(a, b, c, d) {
            this.traverse(a, b, c, d, !0)
        }, parseHTML: function(b, d) {
            var e = [], f = (d || c).createElement("div");
            return f.innerHTML = b, a.merge(e, f.childNodes), e
        }, hasStyling: function(b) {
            var c = a(b);
            return b && (!c.is("p,div") || b.className || c.attr("style") || !a.isEmptyObject(c.data()))
        }, convertElement: function(b, c) {
            for (var d, e, f = b.attributes.length, g = b.ownerDocument.createElement(c); f--; )
                e = b.attributes[f], (!a.sceditor.ie || e.specified) && (a.sceditor.ie < 8 && /style/i.test(e.name) ? b.style.cssText = b.style.cssText : g.setAttribute(e.name, e.value));
            for (; d = b.firstChild; )
                g.appendChild(d);
            return b.parentNode.replaceChild(g, b), g
        }, blockLevelList: "|body|hr|p|div|h1|h2|h3|h4|h5|h6|address|pre|form|table|tbody|thead|tfoot|th|tr|td|li|ol|ul|blockquote|center|", isInline: function(b, c) {
            return b && 1 === b.nodeType ? (b = b.tagName.toLowerCase(), "code" === b ? !c : a.sceditor.dom.blockLevelList.indexOf("|" + b + "|") < 0) : !0
        }, copyCSS: function(a, b) {
            b.style.cssText = a.style.cssText + b.style.cssText
        }, fixNesting: function(a) {
            var b = this, c = function(a) {
                for (; b.isInline(a.parentNode, !0); )
                    a = a.parentNode;
                return a
            };
            b.traverse(a, function(a) {
                if (1 === a.nodeType && !b.isInline(a, !0) && b.isInline(a.parentNode, !0)) {
                    var d = c(a), e = d.parentNode, f = b.extractContents(d, a), g = a;
                    b.copyCSS(d, g), e.insertBefore(f, d), e.insertBefore(g, d)
                }
            })
        }, findCommonAncestor: function(b, c) {
            return a(b).parents().has(a(c)).first()
        }, getSibling: function(b, c) {
            var d;
            return b ? (d = b[c ? "previousSibling" : "nextSibling"]) ? d : a.sceditor.dom.getSibling(b.parentNode, c) : null
        }, removeWhiteSpace: function(b, c) {
            for (var d, e, f, g, h, i, j, k, l = a.sceditor.dom.getSibling, m = a.sceditor.dom.isInline, n = b.firstChild, o = /[\t ]+/g, p = /[\t\n\r ]+/g; n; ) {
                if (i = n.nextSibling, d = n.nodeValue, e = n.nodeType, 1 === e && n.firstChild && (h = a(n).css("whiteSpace"), /pre(?:\-wrap)?$/i.test(h) || a.sceditor.dom.removeWhiteSpace(n, /line$/i.test(h))), 3 === e && d) {
                    for (f = l(n), g = l(n, !0), k = g, j = !1; a(k).hasClass("sceditor-ignore"); )
                        k = l(k, !0);
                    if (m(n) && k) {
                        for (; k.lastChild; )
                            k = k.lastChild;
                        j = 3 === k.nodeType ? /[\t\n\r ]$/.test(k.nodeValue) : !m(k)
                    }
                    m(n) && g && m(g) && !j || (d = d.replace(/^[\t\n\r ]+/, "")), m(n) && f && m(f) || (d = d.replace(/[\t\n\r ]+$/, "")), d.length ? n.nodeValue = d.replace(c ? o : p, " ") : b.removeChild(n)
                }
                n = i
            }
        }, extractContents: function(a, b) {
            var c = this, d = c.findCommonAncestor(a, b), e = d ? d[0] : null, f = !1, g = !1;
            return function h(d) {
                var e = a.ownerDocument.createDocumentFragment();
                return c.traverse(d, function(c) {
                    if (g || c === b && f)
                        return g = !0, !1;
                    c === a && (f = !0);
                    var d, i;
                    f ? jQuery.contains(c, b) && 1 === c.nodeType ? (d = h(c), i = c.cloneNode(!1), i.appendChild(d), e.appendChild(i)) : e.appendChild(c) : jQuery.contains(c, a) && 1 === c.nodeType && (d = h(c), i = c.cloneNode(!1), i.appendChild(d), e.appendChild(i))
                }, !1), e
            }(e)
        }}, a.sceditor.plugins = {}, a.sceditor.PluginManager = function(b) {
        var c = this, d = [], e = b, f = function(a) {
            return"signal" + a.charAt(0).toUpperCase() + a.slice(1)
        }, g = function(a, b) {
            a = [].slice.call(a);
            for (var c = d.length, g = f(a.shift()); c--; )
                if (g in d[c]) {
                    if (b)
                        return d[c][g].apply(e, a);
                    d[c][g].apply(e, a)
                }
        };
        c.call = function() {
            g(arguments, !1)
        }, c.callOnlyFirst = function() {
            return g(arguments, !0)
        }, c.iter = function(a) {
            return a = f(a), function() {
                var b = d.length;
                return{callNext: function(c) {
                        for (; b--; )
                            if (d[b] && a in d[b])
                                return d[b].apply(e, c)
                    }, hasNext: function() {
                        for (var c = b; c--; )
                            if (d[c] && a in d[c])
                                return!0;
                        return!1
                    }}
            }()
        }, c.hasHandler = function(a) {
            var b = d.length;
            for (a = f(a); b--; )
                if (a in d[b])
                    return!0;
            return!1
        }, c.exsists = function(b) {
            return b in a.sceditor.plugins ? (b = a.sceditor.plugins[b], "function" == typeof b && "object" == typeof b.prototype) : !1
        }, c.isRegistered = function(b) {
            var e = d.length;
            if (!c.exsists(b))
                return!1;
            for (; e--; )
                if (d[e]instanceof a.sceditor.plugins[b])
                    return!0;
            return!1
        }, c.register = function(b) {
            return c.exsists(b) ? (b = new a.sceditor.plugins[b], d.push(b), "init"in b && b.init.apply(e), !0) : !1
        }, c.deregister = function(b) {
            var f, g = d.length, h = !1;
            if (!c.isRegistered(b))
                return!1;
            for (; g--; )
                d[g]instanceof a.sceditor.plugins[b] && (f = d.splice(g, 1)[0], h = !0, "destroy"in f && f.destroy.apply(e));
            return h
        }, c.destroy = function() {
            for (var a = d.length; a--; )
                "destroy"in d[a] && d[a].destroy.apply(e);
            d = null, e = null
        }
    }, a.sceditor.command = {get: function(b) {
            return a.sceditor.commands[b] || null
        }, set: function(b, c) {
            return b && c ? (c = a.extend(a.sceditor.commands[b] || {}, c), c.remove = function() {
                a.sceditor.command.remove(b)
            }, a.sceditor.commands[b] = c, this) : !1
        }, remove: function(b) {
            return a.sceditor.commands[b] && delete a.sceditor.commands[b], this
        }}, a.sceditor.defaultOptions = {toolbar: "bold,italic,underline,strike,subscript,superscript|left,center,right,justify|font,size,color,removeformat|cut,copy,paste,pastetext|bulletlist,orderedlist|table|code,quote|horizontalrule,image,email,link,unlink|emoticon,youtube,date,time|ltr,rtl|source", toolbarExclude: null, style: "jquery.sceditor.default.css", fonts: "Arial,Arial Black,Comic Sans MS,Courier New,Georgia,Impact,Sans-serif,Serif,Times New Roman,Trebuchet MS,Verdana", colors: null, locale: "en", charset: "utf-8", emoticonsCompat: !1, emoticonsEnabled: !0, emoticonsRoot: "http://testppp.i3portal.net/wp-content/themes/piratenkleider/images/", emoticons: {dropdown: {":)": "emoticons/smile.png", ":angel:": "emoticons/angel.png", ":angry:": "emoticons/angry.png", "8-)": "emoticons/cool.png", ":'(": "emoticons/cwy.png", ":ermm:": "emoticons/ermm.png", ":D": "emoticons/grin.png", "<3": "emoticons/heart.png", ":(": "emoticons/sad.png", ":O": "emoticons/shocked.png", ":P": "emoticons/tongue.png", ";)": "emoticons/wink.png"}, more: {":alien:": "emoticons/alien.png", ":blink:": "emoticons/blink.png", ":blush:": "emoticons/blush.png", ":cheerful:": "emoticons/cheerful.png", ":devil:": "emoticons/devil.png", ":dizzy:": "emoticons/dizzy.png", ":getlost:": "emoticons/getlost.png", ":happy:": "emoticons/happy.png", ":kissing:": "emoticons/kissing.png", ":ninja:": "emoticons/ninja.png", ":pinch:": "emoticons/pinch.png", ":pouty:": "emoticons/pouty.png", ":sick:": "emoticons/sick.png", ":sideways:": "emoticons/sideways.png", ":silly:": "emoticons/silly.png", ":sleeping:": "emoticons/sleeping.png", ":unsure:": "emoticons/unsure.png", ":woot:": "emoticons/w00t.png", ":wassat:": "emoticons/wassat.png"}, hidden: {":whistling:": "emoticons/whistling.png", ":love:": "emoticons/wub.png"}}, width: null, height: null, resizeEnabled: !0, resizeMinWidth: null, resizeMinHeight: null, resizeMaxHeight: null, resizeMaxWidth: null, resizeHeight: !0, resizeWidth: !0, getHtmlHandler: null, getTextHandler: null, dateFormat: "year-month-day", toolbarContainer: null, enablePasteFiltering: !1, disablePasting: !1, readOnly: !1, rtl: !1, autofocus: !1, autofocusEnd: !0, autoExpand: !1, autoUpdate: !1, spellcheck: !0, runWithoutWysiwygSupport: !1, id: null, plugins: "", zIndex: null, bbcodeTrim: !1, disableBlockRemove: !1, parserOptions: {}, dropDownCss: {}}, a.fn.sceditor = function(b) {
        var c, d = [];
        return b = b || {}, b.runWithoutWysiwygSupport || a.sceditor.isWysiwygSupported ? (this.each(function() {
            c = this.jquery ? this : a(this), c.parents(".sceditor-container").length > 0 || ("state" === b ? d.push(!!c.data("sceditor")) : "instance" === b ? d.push(c.data("sceditor")) : c.data("sceditor") || new a.sceditor(this, b))
        }), d.length ? 1 === d.length ? d[0] : a(d) : this) : void 0
    }
}(jQuery, window, document), function(a, b, c) {
    "use strict";
    a.sceditor.BBCodeParser = function(b) {
        if (!(this instanceof a.sceditor.BBCodeParser))
            return new a.sceditor.BBCodeParser(b);
        var d, e, f, g, h, i, j, k, l, m, n, o, p, q, r, s = this, t = {open: "open", content: "content", newline: "newline", close: "close"}, u = function(a, b, c, d, e, f) {
            var g = this;
            g.type = a, g.name = b, g.val = c, g.attrs = d || {}, g.children = e || [], g.closing = f || null
        };
        u.prototype = {clone: function(a) {
                var b = this;
                return new u(b.type, b.name, b.val, b.attrs, a ? b.children : [], b.closing ? b.closing.clone() : null)
            }, splitAt: function(b) {
                var c, d = this, e = 0, f = d.children.length;
                if ("number" != typeof object && (b = a.inArray(b, d.children)), 0 > b || b > f)
                    return null;
                for (; f--; )
                    f >= b ? e++ : f = 0;
                return c = d.clone(), c.children = d.children.splice(b, e), c
            }}, d = function() {
            s.opts = a.extend({}, a.sceditor.BBCodeParser.defaults, b), s.bbcodes = a.sceditor.plugins.bbcode.bbcodes
        }, s.tokenize = function(a) {
            var b, c, d, f = [], g = [{type: "close", regex: /^\[\/[^\[\]]+\]/}, {type: "open", regex: /^\[[^\[\]]+\]/}, {type: "newline", regex: /^(\r\n|\r|\n)/}, {type: "content", regex: /^([^\[\r\n]+|\[)/}];
            g.reverse();
            a:for (; a.length; ) {
                for (d = g.length; d--; )
                    if (c = g[d].type, (b = a.match(g[d].regex)) && b[0]) {
                        f.push(e(c, b[0])), a = a.substr(b[0].length);
                        continue a
                    }
                a.length && f.push(e(t.content, a)), a = ""
            }
            return f
        }, e = function(b, c) {
            var d, e, g;
            return"open" === b && (d = c.match(/\[([^\]\s=]+)(?:([^\]]+))?\]/)) ? (g = q(d[1]), d[2] && (d[2] = a.trim(d[2])) && (e = f(d[2]))) : "close" === b && (d = c.match(/\[\/([^\[\]]+)\]/)) ? g = q(d[1]) : "newline" === b && (g = "#newline"), g && ("open" !== b && "close" !== b || a.sceditor.plugins.bbcode.bbcodes[g]) || (b = "content", g = "#"), new u(b, g, c, e)
        }, f = function(b) {
            var c, d = /([^\s=]+)=(?:(?:(["'])((?:\\\2|[^\2])*?)\2)|((?:.(?!\s\S+=))*.))/g, e = a.sceditor.plugins.bbcode.stripQuotes, f = {};
            if ("=" === b.charAt(0) && b.indexOf("=", 1) < 0)
                f.defaultattr = e(b.substr(1));
            else
                for ("=" === b.charAt(0) && (b = "defaultattr" + b); c = d.exec(b); )
                    f[q(c[1])] = e(c[3]) || c[4];
            return f
        }, s.parse = function(a, b) {
            var c = g(s.tokenize(a));
            return s.opts.fixInvalidChildren && l(c), s.opts.removeEmptyTags && k(c), s.opts.fixInvalidNesting && i(c), h(c, null, b), s.opts.removeEmptyTags && k(c), c
        }, o = function(a, b, c) {
            for (var d = c.length; d--; )
                if (c[d].type === b && c[d].name === a)
                    return!0;
            return!1
        }, j = function(b, c) {
            var d = b ? s.bbcodes[b.name] : null, e = d ? d.allowedChildren : null;
            return s.opts.fixInvalidChildren && e ? e && a.inArray(c.name || "#", e) < 0 ? !1 : !0 : !0
        }, g = function(b) {
            for (var c, d, e, f, g, h, i, j = [], k = [], l = [], m = function() {
                return r(l)
            }, n = function(a) {
                m() ? m().children.push(a) : k.push(a)
            }, p = function(b) {
                return m() && (d = s.bbcodes[m().name]) && d.closedBy && a.inArray(b, d.closedBy) > -1
            }; c = b.shift(); ) {
                switch (i = b[0], c.type) {
                    case t.open:
                        p(c.name) && l.pop(), n(c), d = s.bbcodes[c.name], d && d.isSelfClosing || !d.closedBy && !o(c.name, t.close, b) ? d && d.isSelfClosing || (c.type = t.content) : l.push(c);
                        break;
                    case t.close:
                        if (m() && c.name !== m().name && p("/" + c.name) && l.pop(), m() && c.name === m().name)
                            m().closing = c, l.pop();
                        else if (o(c.name, t.open, l)) {
                            for (; e = l.pop(); ) {
                                if (e.name === c.name) {
                                    e.closing = c;
                                    break
                                }
                                f = e.clone(), j.length > 1 && f.children.push(r(j)), j.push(f)
                            }
                            for (n(r(j)), g = j.length; g--; )
                                l.push(j[g]);
                            j.length = 0
                        } else
                            c.type = t.content, n(c);
                        break;
                    case t.newline:
                        m() && i && p((i.type === t.close ? "/" : "") + i.name) && (i.type !== t.close || i.name !== m().name) && (d = s.bbcodes[m().name], d && d.breakAfter ? l.pop() : d && d.isInline === !1 && s.opts.breakAfterBlock && d.breakAfter !== !1 && l.pop()), n(c);
                        break;
                    default:
                        n(c)
                }
                h = c
            }
            return k
        }, h = function(a, b, c) {
            var d, e, f, g, i, j, k, l, m = a.length, n = m;
            for (b && (g = s.bbcodes[b.name]); n--; )
                if (d = a[n])
                    if (d.type === t.newline) {
                        if (e = n > 0 ? a[n - 1] : null, f = m - 1 > n ? a[n + 1] : null, l = !1, !c && g && g.isSelfClosing !== !0 && (e ? j || f || (g.isInline === !1 && s.opts.breakEndBlock && g.breakEnd !== !1 && (l = !0), g.breakEnd && (l = !0), j = l) : (g.isInline === !1 && s.opts.breakStartBlock && g.breakStart !== !1 && (l = !0), g.breakStart && (l = !0))), e && e.type === t.open && (i = s.bbcodes[e.name]) && (c ? i.isInline === !1 && (l = !0) : (i.isInline === !1 && s.opts.breakAfterBlock && i.breakAfter !== !1 && (l = !0), i.breakAfter && (l = !0))), !c && !k && f && f.type === t.open && (i = s.bbcodes[f.name]) && (i.isInline === !1 && s.opts.breakBeforeBlock && i.breakBefore !== !1 && (l = !0), i.breakBefore && (l = !0), k = l, l)) {
                            a.splice(n, 1);
                            continue
                        }
                        l && a.splice(n, 1), k = !1
                    } else
                        d.type === t.open && h(d.children, d, c)
        }, i = function(b, c, d, e) {
            var f, g, h, j, k, l, m = function(a) {
                var b = s.bbcodes[a.name];
                return!b || b.isInline !== !1
            };
            for (c = c || [], e = e || b, g = 0; g < b.length; g++)
                if ((f = b[g]) && f.type === t.open) {
                    if (!m(f) && d && (h = r(c), l = h.splitAt(f), k = c.length > 1 ? c[c.length - 2].children : e, (j = a.inArray(h, k)) > -1))
                        return l.children.splice(a.inArray(f, l.children), 1), k.splice(j + 1, 0, f, l), void 0;
                    c.push(f), i(f.children, c, d || m(f), e), c.pop(f)
                }
        }, l = function(a, b) {
            for (var c, d, e = a.length; e--; )
                (c = a[e]) && (j(b, c) || (c.name = null, c.type = t.content, j(b, c) ? (d = [e + 1, 0].concat(c.children), c.closing && (c.closing.name = null, c.closing.type = t.content, d.push(c.closing)), e += d.length - 1, Array.prototype.splice.apply(a, d)) : b.children.splice(e, 1)), c.type === t.open && l(c.children, c))
        }, k = function(b) {
            var c, d, e, f = b.length;
            for (e = function(a) {
                for (var b = a.length; b--; ) {
                    if (a[b].type === t.open)
                        return!1;
                    if (a[b].type === t.close)
                        return!1;
                    if (a[b].type === t.content && a[b].val && /\S|\u00A0/.test(a[b].val))
                        return!1
                }
                return!0
            }; f--; )
                (c = b[f]) && c.type === t.open && (d = s.bbcodes[c.name], k(c.children), e(c.children) && d && !d.isSelfClosing && !d.allowsEmpty && b.splice.apply(b, a.merge([f, 1], c.children)))
        }, s.toHTML = function(a, b) {
            return m(s.parse(a, b), !0)
        }, m = function(b, d) {
            var e, f, g, h, i, j, k, l, n = [];
            for (k = function(a) {
                return(!a || ("undefined" != typeof a.isHtmlInline ? a.isHtmlInline : a.isInline)) !== !1
            }; b.length > 0; )
                if (e = b.shift()) {
                    if (e.type === t.open)
                        l = e.children[e.children.length - 1] || {}, f = s.bbcodes[e.name], i = d && k(f), g = m(e.children, !1), f && f.html ? (k(f) || !k(s.bbcodes[l.name]) || f.isPreFormatted || f.skipLastLineBreak || a.sceditor.ie || (g += "<br />"), h = a.isFunction(f.html) ? f.html.call(s, e, e.attrs, g) : a.sceditor.plugins.bbcode.formatString(f.html, g)) : h = e.val + g + (e.closing ? e.closing.val : "");
                    else {
                        if (e.type === t.newline) {
                            if (!d) {
                                n.push("<br />");
                                continue
                            }
                            j || (n.push("<div>"), (c.documentMode && c.documentMode < 8 || a.sceditor.ie < 8) && n.push(" ")), a.sceditor.ie || n.push("<br />"), b.length || n.push("<br />"), n.push("</div>\n"), j = !1;
                            continue
                        }
                        i = d, h = a.sceditor.escapeEntities(e.val)
                    }
                    i && !j ? (n.push("<div>"), j = !0) : !i && j && (n.push("</div>\n"), j = !1), n.push(h)
                }
            return j && n.push("</div>\n"), n.join("")
        }, s.toBBCode = function(a, b) {
            return n(s.parse(a, b))
        }, n = function(b) {
            for (var c, d, e, f, g, h, i, j, k, l, m = []; b.length > 0; )
                if (c = b.shift())
                    if (e = s.bbcodes[c.name], f = !(!e || e.isInline !== !1), g = e && e.isSelfClosing, i = f && s.opts.breakBeforeBlock && e.breakBefore !== !1 || e && e.breakBefore, j = f && !g && s.opts.breakStartBlock && e.breakStart !== !1 || e && e.breakStart, k = f && s.opts.breakEndBlock && e.breakEnd !== !1 || e && e.breakEnd, l = f && s.opts.breakAfterBlock && e.breakAfter !== !1 || e && e.breakAfter, h = (e ? e.quoteType : null) || s.opts.quoteType || a.sceditor.BBCodeParser.QuoteType.auto, e || c.type !== t.open)
                        if (c.type === t.open) {
                            if (i && m.push("\n"), m.push("[" + c.name), c.attrs) {
                                c.attrs.defaultattr && (m.push("=" + p(c.attrs.defaultattr, h, "defaultattr")), delete c.attrs.defaultattr);
                                for (d in c.attrs)
                                    c.attrs.hasOwnProperty(d) && m.push(" " + d + "=" + p(c.attrs[d], h, d))
                            }
                            m.push("]"), j && m.push("\n"), c.children && m.push(n(c.children)), g || e.excludeClosing || (k && m.push("\n"), m.push("[/" + c.name + "]")), l && m.push("\n"), c.closing && g && m.push(c.closing.val)
                        } else
                            m.push(c.val);
                    else
                        m.push(c.val), c.children && m.push(n(c.children)), c.closing && m.push(c.closing.val);
            return m.join("")
        }, p = function(b, c, d) {
            var e = a.sceditor.BBCodeParser.QuoteType, f = /\s|=/.test(b);
            return a.isFunction(c) ? c(b, d) : c === e.never || c === e.auto && !f ? b : '"' + b.replace("\\", "\\\\").replace('"', '\\"') + '"'
        }, r = function(a) {
            return a.length ? a[a.length - 1] : null
        }, q = function(a) {
            return a.toLowerCase()
        }, d()
    }, a.sceditor.BBCodeParser.QuoteType = {always: 1, never: 2, auto: 3}, a.sceditor.BBCodeParser.defaults = {breakBeforeBlock: !1, breakStartBlock: !1, breakEndBlock: !1, breakAfterBlock: !0, removeEmptyTags: !0, fixInvalidNesting: !0, fixInvalidChildren: !0, quoteType: a.sceditor.BBCodeParser.QuoteType.auto}, a.sceditorBBCodePlugin = a.sceditor.plugins.bbcode = function() {
        var b, d, e, f, g, h, i, j = this;
        f = a.sceditor.plugins.bbcode.formatString, j.bbcodes = a.sceditor.plugins.bbcode.bbcodes, j.stripQuotes = a.sceditor.plugins.bbcode.stripQuotes;
        var k = {}, l = {}, m = {ul: ["li", "ol", "ul"], ol: ["li", "ol", "ul"], table: ["tr"], tr: ["td", "th"], code: ["br", "p", "div"]}, n = {};
        j.init = function() {
            j.opts = this.opts, b(), h(this), this.toBBCode = j.signalToSource, this.fromBBCode = j.signalToWysiwyg
        }, h = function(b) {
            var c = a.sceditor.command.get, d = {bold: {txtExec: ["[b]", "[/b]"]}, italic: {txtExec: ["[i]", "[/i]"]}, underline: {txtExec: ["[u]", "[/u]"]}, strike: {txtExec: ["[s]", "[/s]"]}, subscript: {txtExec: ["[sub]", "[/sub]"]}, superscript: {txtExec: ["[sup]", "[/sup]"]}, left: {txtExec: ["[left]", "[/left]"]}, center: {txtExec: ["[center]", "[/center]"]}, right: {txtExec: ["[right]", "[/right]"]}, justify: {txtExec: ["[justify]", "[/justify]"]}, font: {txtExec: function(a) {
                        var b = this;
                        c("font")._dropDown(b, a, function(a) {
                            b.insertText("[font=" + a + "]", "[/font]")
                        })
                    }}, size: {txtExec: function(a) {
                        var b = this;
                        c("size")._dropDown(b, a, function(a) {
                            b.insertText("[size=" + a + "]", "[/size]")
                        })
                    }}, color: {txtExec: function(a) {
                        var b = this;
                        c("color")._dropDown(b, a, function(a) {
                            b.insertText("[color=" + a + "]", "[/color]")
                        })
                    }}, bulletlist: {txtExec: function(c, d) {
                        var e = "";
                        a.each(d.split(/\r?\n/), function() {
                            e += (e ? "\n" : "") + "[li]" + this + "[/li]"
                        }), b.insertText("[ul]\n" + e + "\n[/ul]")
                    }}, orderedlist: {txtExec: function(c, d) {
                        var e = "";
                        a.each(d.split(/\r?\n/), function() {
                            e += (e ? "\n" : "") + "[li]" + this + "[/li]"
                        }), a.sceditor.plugins.bbcode.bbcode.get(""), b.insertText("[ol]\n" + e + "\n[/ol]")
                    }}, table: {txtExec: ["[table][tr][td]", "[/td][/tr][/table]"]}, horizontalrule: {txtExec: ["[hr]"]}, code: {txtExec: ["[code]", "[/code]"]}, image: {txtExec: function(a, b) {
                        var c = prompt(this._("Enter the image URL:"), b);
                        c && this.insertText("[img]" + c + "[/img]")
                    }}, email: {txtExec: function(a, b) {
                        var c = b && b.indexOf("@") > -1 ? null : b, d = prompt(this._("Enter the e-mail address:"), c ? "" : b), e = prompt(this._("Enter the displayed text:"), c || d) || d;
                        d && this.insertText("[email=" + d + "]" + e + "[/email]")
                    }}, link: {txtExec: function(a, b) {
                        var c = b && b.indexOf("http://") > -1 ? null : b, d = prompt(this._("Enter URL:"), c ? "http://" : b), e = prompt(this._("Enter the displayed text:"), c || d) || d;
                        d && this.insertText("[url=" + d + "]" + e + "[/url]")
                    }}, quote: {txtExec: ["[quote]", "[/quote]"]}, youtube: {txtExec: function(a) {
                        var b = this;
                        c("youtube")._dropDown(b, a, function(a) {
                            b.insertText("[youtube]" + a + "[/youtube]")
                        })
                    }}, rtl: {txtExec: ["[rtl]", "[/rtl]"]}, ltr: {txtExec: ["[ltr]", "[/ltr]"]}};
            b.commands = a.extend(!0, {}, d, b.commands)
        }, b = function() {
            a.each(j.bbcodes, function(b) {
                j.bbcodes[b].tags && a.each(j.bbcodes[b].tags, function(a, c) {
                    var d = j.bbcodes[b].isInline === !1;
                    k[a] = k[a] || {}, k[a][d] = k[a][d] || {}, k[a][d][b] = c
                }), j.bbcodes[b].styles && a.each(j.bbcodes[b].styles, function(a, c) {
                    var d = j.bbcodes[b].isInline === !1;
                    l[d] = l[d] || {}, l[d][a] = l[d][a] || {}, l[d][a][b] = c
                })
            })
        }, g = function(b, c) {
            var d, e, f, g, h, i = b.style;
            return i ? (n[c] || (n[c] = a.camelCase(c)), h = n[c], "text-align" === c ? (d = a(b), f = i.direction, g = i[h] || d.css(c), d.parent().css(c) === g || "block" !== d.css("display") || d.is("hr") || d.is("th") || (e = g), f && e && (/right/i.test(e) && "rtl" === f || /left/i.test(e) && "ltr" === f) ? null : e) : i[h]) : null
        }, d = function(b, c, d) {
            var e;
            return d = !!d, l[d] ? (a.each(l[d], function(d, h) {
                e = g(b[0], d), e && g(b.parent()[0], d) !== e && a.each(h, function(d, g) {
                    (!g || a.inArray(e.toString(), g) > -1) && (c = a.isFunction(j.bbcodes[d].format) ? j.bbcodes[d].format.call(j, b, c) : f(j.bbcodes[d].format, c))
                })
            }), c) : c
        }, e = function(b, c, d) {
            var e, g = b[0], h = g.nodeName.toLowerCase();
            if (d = !!d, k[h] && k[h][d] && a.each(k[h][d], function(d, g) {
                (!g || (e = !1, a.each(g, function(c, d) {
                    return!b.attr(c) || d && a.inArray(b.attr(c), d) < 0 ? void 0 : (e = !0, !1)
                }), e)) && (c = a.isFunction(j.bbcodes[d].format) ? j.bbcodes[d].format.call(j, b, c) : f(j.bbcodes[d].format, c))
            }), d && (!a.sceditor.dom.isInline(g, !0) || "br" === h)) {
                for (var i = g.parentNode, l = i.lastChild, m = g.previousSibling, n = a.sceditor.dom.isInline(i, !0); m && a(m).hasClass("sceditor-ignore"); )
                    m = m.previousSibling;
                for (; a(l).hasClass("sceditor-ignore"); )
                    l = l.previousSibling;
                (n || l !== g || "li" === h || "br" === h && a.sceditor.ie) && (c += "\n"), "br" !== h && m && "br" !== m.nodeName.toLowerCase() && a.sceditor.dom.isInline(m, !0) && (c = "\n" + c)
            }
            return c
        }, j.signalToSource = function(b, d) {
            var e, f, g = new a.sceditor.BBCodeParser(j.opts.parserOptions);
            return d || ("string" == typeof b ? (e = a("<div />").css("visibility", "hidden").appendTo(c.body).html(b), d = e) : d = a(b)), d && d.jquery ? (a.sceditor.dom.removeWhiteSpace(d[0]), f = j.elementToBbcode(d), e && e.remove(), f = g.toBBCode(f, !0), j.opts.bbcodeTrim && (f = a.trim(f)), f) : ""
        }, j.elementToBbcode = function(b) {
            return function c(b, f) {
                var g = "";
                return a.sceditor.dom.traverse(b, function(b) {
                    var h = a(b), i = "", j = b.nodeType, k = b.nodeName.toLowerCase(), l = m[k], n = b.firstChild, o = !0;
                    if ("object" == typeof f && (o = a.inArray(k, f) > -1, h.is("img") && h.data("sceditor-emoticon") && (o = !0), o || (l = f)), 3 === j || 1 === j)
                        if (1 === j) {
                            if (h.hasClass("sceditor-ignore"))
                                return;
                            if (h.hasClass("sceditor-nlf") && (!n || !a.sceditor.ie && 1 === b.childNodes.length && /br/i.test(n.nodeName)))
                                return;
                            "iframe" !== k && (i = c(b, l)), o ? ("code" !== k && (i = d(h, i), i = e(h, i), i = d(h, i, !0)), g += e(h, i, !0)) : g += i
                        } else
                            !b.wholeText || b.previousSibling && 3 === b.previousSibling.nodeType ? b.wholeText || (g += b.nodeValue) : g += 0 === h.parents("code").length ? b.wholeText.replace(/ +/g, " ") : b.wholeText
                }, !1, !0), g
            }(b[0])
        }, j.signalToWysiwyg = function(b, c) {
            var d = new a.sceditor.BBCodeParser(j.opts.parserOptions), e = d.toHTML(j.opts.bbcodeTrim ? a.trim(b) : b);
            return c ? i(e) : e
        }, i = function(b) {
            var d, e, f, g = a("<div />").hide().appendTo(c.body), h = g[0];
            return f = function(b, d) {
                if (!a.sceditor.dom.hasStyling(b)) {
                    if (a.sceditor.ie || 1 !== b.childNodes.length || !a(b.firstChild).is("br"))
                        for (; e = b.firstChild; )
                            h.insertBefore(e, b);
                    if (d) {
                        var f = h.lastChild;
                        b !== f && a(f).is("div") && b.nextSibling === f && h.insertBefore(c.createElement("br"), b)
                    }
                    h.removeChild(b)
                }
            }, h.innerHTML = b.replace(/<\/div>\n/g, "</div>"), (d = h.firstChild) && a(d).is("div") && f(d, !0), (d = h.lastChild) && a(d).is("div") && f(d), h = h.innerHTML, g.remove(), h
        }
    }, a.sceditor.plugins.bbcode.stripQuotes = function(a) {
        return a ? a.replace(/\\(.)/g, "$1").replace(/^(["'])(.*?)\1$/, "$2") : a
    }, a.sceditor.plugins.bbcode.formatString = function() {
        var a = arguments;
        return a[0].replace(/\{(\d+)\}/g, function(b, c) {
            return"undefined" != typeof a[c - 0 + 1] ? a[c - 0 + 1] : "{" + c + "}"
        })
    };
    var d = a.sceditor.plugins.bbcode.normaliseColour = function(a) {
        var b, c;
        return c = function(a) {
            return a = parseInt(a, 10), isNaN(a) ? "00" : (a = Math.max(0, Math.min(a, 255)).toString(16), a.length < 2 ? "0" + a : a)
        }, a = a || "#000", (b = a.match(/rgb\((\d{1,3}),\s*?(\d{1,3}),\s*?(\d{1,3})\)/i)) ? "#" + c(b[1]) + c(b[2] - 0) + c(b[3] - 0) : (b = a.match(/#([0-f])([0-f])([0-f])\s*?$/i)) ? "#" + b[1] + b[1] + b[2] + b[2] + b[3] + b[3] : a
    };
    a.sceditor.plugins.bbcode.bbcodes = {b: {tags: {b: null, strong: null}, styles: {"font-weight": ["bold", "bolder", "401", "700", "800", "900"]}, format: "[b]{0}[/b]", html: "<strong>{0}</strong>"}, i: {tags: {i: null, em: null}, styles: {"font-style": ["italic", "oblique"]}, format: "[i]{0}[/i]", html: "<em>{0}</em>"}, u: {tags: {u: null}, styles: {"text-decoration": ["underline"]}, format: "[u]{0}[/u]", html: "<u>{0}</u>"}, s: {tags: {s: null, strike: null}, styles: {"text-decoration": ["line-through"]}, format: "[s]{0}[/s]", html: "<s>{0}</s>"}, sub: {tags: {sub: null}, format: "[sub]{0}[/sub]", html: "<sub>{0}</sub>"}, sup: {tags: {sup: null}, format: "[sup]{0}[/sup]", html: "<sup>{0}</sup>"}, font: {tags: {font: {face: null}}, styles: {"font-family": null}, quoteType: a.sceditor.BBCodeParser.QuoteType.never, format: function(a, b) {
                var c;
                return"font" === a[0].nodeName.toLowerCase() && (c = a.attr("face")) || (c = a.css("font-family")), "[font=" + this.stripQuotes(c) + "]" + b + "[/font]"
            }, html: function(a, b, c) {
                return'<font face="' + b.defaultattr + '">' + c + "</font>"
            }}, size: {tags: {font: {size: null}}, styles: {"font-size": null}, format: function(a, b) {
                var c = a.attr("size"), d = 1;
                return c || (c = a.css("fontSize")), c.indexOf("px") > -1 ? (c = c.replace("px", "") - 0, c > 12 && (d = 2), c > 15 && (d = 3), c > 17 && (d = 4), c > 23 && (d = 5), c > 31 && (d = 6), c > 47 && (d = 7)) : d = c, "[size=" + d + "]" + b + "[/size]"
            }, html: function(a, b, c) {
                return'<font size="' + b.defaultattr + '">' + c + "</font>"
            }}, color: {tags: {font: {color: null}}, styles: {color: null}, quoteType: a.sceditor.BBCodeParser.QuoteType.never, format: function(a, b) {
                var c, e = a[0];
                return"font" === e.nodeName.toLowerCase() && (c = a.attr("color")) || (c = e.style.color || a.css("color")), "[color=" + d(c) + "]" + b + "[/color]"
            }, html: function(a, b, c) {
                return'<font color="' + d(b.defaultattr) + '">' + c + "</font>"
            }}, ul: {tags: {ul: null}, breakStart: !0, isInline: !1, skipLastLineBreak: !0, format: "[ul]{0}[/ul]", html: "<ul>{0}</ul>"}, list: {breakStart: !0, isInline: !1, skipLastLineBreak: !0, html: "<ul>{0}</ul>"}, ol: {tags: {ol: null}, breakStart: !0, isInline: !1, skipLastLineBreak: !0, format: "[ol]{0}[/ol]", html: "<ol>{0}</ol>"}, li: {tags: {li: null}, isInline: !1, closedBy: ["/ul", "/ol", "/list", "*", "li"], format: "[li]{0}[/li]", html: "<li>{0}</li>"}, "*": {isInline: !1, closedBy: ["/ul", "/ol", "/list", "*", "li"], html: "<li>{0}</li>"}, table: {tags: {table: null}, isInline: !1, isHtmlInline: !0, skipLastLineBreak: !0, format: "[table]{0}[/table]", html: "<table>{0}</table>"}, tr: {tags: {tr: null}, isInline: !1, skipLastLineBreak: !0, format: "[tr]{0}[/tr]", html: "<tr>{0}</tr>"}, th: {tags: {th: null}, allowsEmpty: !0, isInline: !1, format: "[th]{0}[/th]", html: "<th>{0}</th>"}, td: {tags: {td: null}, allowsEmpty: !0, isInline: !1, format: "[td]{0}[/td]", html: "<td>{0}</td>"}, emoticon: {allowsEmpty: !0, tags: {img: {src: null, "data-sceditor-emoticon": null}}, format: function(a, b) {
                return a.data("sceditor-emoticon") + b
            }, html: "{0}"}, hr: {tags: {hr: null}, allowsEmpty: !0, isSelfClosing: !0, isInline: !1, format: "[hr]{0}", html: "<hr />"}, img: {allowsEmpty: !0, tags: {img: {src: null}}, quoteType: a.sceditor.BBCodeParser.QuoteType.never, format: function(a, b) {
                var c, d, e = "", f = a[0], g = function(a) {
                    return f.style ? f.style[a] : null
                };
                return a.attr("data-sceditor-emoticon") ? b : (c = a.attr("width") || g("width"), d = a.attr("height") || g("height"), (f.complete && (c || d) || c && d) && (e = "=" + a.width() + "x" + a.height()), "[img" + e + "]" + a.attr("src") + "[/img]")
            }, html: function(a, b, c) {
                var d, e = "";
                return"undefined" != typeof b.width && (e += ' width="' + b.width + '"'), "undefined" != typeof b.height && (e += ' height="' + b.height + '"'), b.defaultattr && (d = b.defaultattr.split(/x/i), e = ' width="' + d[0] + '"' + ' height="' + (2 === d.length ? d[1] : d[0]) + '"'), "<img" + e + ' src="' + c + '" />'
            }}, url: {allowsEmpty: !0, tags: {a: {href: null}}, quoteType: a.sceditor.BBCodeParser.QuoteType.never, format: function(a, b) {
                var c = a.attr("href");
                return"mailto:" === c.substr(0, 7) ? '[email="' + c.substr(7) + '"]' + b + "[/email]" : "[url=" + decodeURI(c) + "]" + b + "[/url]"
            }, html: function(a, b, c) {
                return'<a href="' + encodeURI(b.defaultattr || c) + '">' + c + "</a>"
            }}, email: {quoteType: a.sceditor.BBCodeParser.QuoteType.never, html: function(a, b, c) {
                return'<a href="mailto:' + (b.defaultattr || c) + '">' + c + "</a>"
            }}, quote: {tags: {blockquote: null}, isInline: !1, quoteType: a.sceditor.BBCodeParser.QuoteType.never, format: function(b, c) {
                var d = "", e = a(b), f = e.children("cite").first();
                return(1 === f.length || e.data("author")) && (d = f.text() || e.data("author"), e.data("author", d), f.remove(), c = this.elementToBbcode(a(b)), d = "=" + d, e.prepend(f)), "[quote" + d + "]" + c + "[/quote]"
            }, html: function(a, b, c) {
                return b.defaultattr && (c = "<cite>" + b.defaultattr + "</cite>" + c), "<blockquote>" + c + "</blockquote>"
            }}, code: {tags: {code: null}, isInline: !1, allowedChildren: ["#", "#newline"], format: "[code]{0}[/code]", html: "<code>{0}</code>"}, left: {styles: {"text-align": ["left", "-webkit-left", "-moz-left", "-khtml-left"]}, isInline: !1, format: "[left]{0}[/left]", html: '<div align="left">{0}</div>'}, center: {styles: {"text-align": ["center", "-webkit-center", "-moz-center", "-khtml-center"]}, isInline: !1, format: "[center]{0}[/center]", html: '<div align="center">{0}</div>'}, right: {styles: {"text-align": ["right", "-webkit-right", "-moz-right", "-khtml-right"]}, isInline: !1, format: "[right]{0}[/right]", html: '<div align="right">{0}</div>'}, justify: {styles: {"text-align": ["justify", "-webkit-justify", "-moz-justify", "-khtml-justify"]}, isInline: !1, format: "[justify]{0}[/justify]", html: '<div align="justify">{0}</div>'}, youtube: {allowsEmpty: !0, tags: {iframe: {"data-youtube-id": null}}, format: function(a, b) {
                return a = a.attr("data-youtube-id"), a ? "[youtube]" + a + "[/youtube]" : b
            }, html: '<iframe width="560" height="315" src="http://www.youtube.com/embed/{0}?wmode=opaque" data-youtube-id="{0}" frameborder="0" allowfullscreen></iframe>'}, rtl: {styles: {direction: ["rtl"]}, format: "[rtl]{0}[/rtl]", html: '<div style="direction: rtl">{0}</div>'}, ltr: {styles: {direction: ["ltr"]}, format: "[ltr]{0}[/ltr]", html: '<div style="direction: ltr">{0}</div>'}, ignore: {}}, a.sceditor.plugins.bbcode.bbcode = {get: function(b) {
            return a.sceditor.plugins.bbcode.bbcodes[b] || null
        }, set: function(b, c) {
            return b && c ? (c = a.extend(a.sceditor.plugins.bbcode.bbcodes[b] || {}, c), c.remove = function() {
                a.sceditor.plugins.bbcode.bbcode.remove(b)
            }, a.sceditor.plugins.bbcode.bbcodes[b] = c, this) : !1
        }, rename: function(a, b) {
            return this.hasOwnProperty(a) ? (this[b] = this[a], this.remove(a), this) : !1
        }, remove: function(b) {
            return a.sceditor.plugins.bbcode.bbcodes[b] && delete a.sceditor.plugins.bbcode.bbcodes[b], this
        }}, a.fn.sceditorBBCodePlugin = function(b) {
        return b = b || {}, a.isPlainObject(b) && (b.plugins = (b.plugins ? b.plugins : "") + "bbcode"), this.sceditor(b)
    }
}(jQuery, window, document);