function ajaxGet( formData, processResponse = (response) => {} ) {
    const URL = AJAX_URL + serialize(formData);
    $.ajax({
        type : "get",
        dataType : "json",
        processData: false,
        contentType: false,
        url : URL,
        context: this,
        beforeSend: function() {
        },
        success: function(response, status, xhr) {
            processResponse(response);
        },
        error: function( jqXHR, textStatus, errorThrown ) {
            //$("#loading-image").addClass("hidden").removeClass("loading-image");
            //console.log("Error!");
        }
    });
};

function ajaxPost( formData, processResponse = (response) => {} ) {
    $.ajax({
        type : "post",
        dataType : "json",
        data: formData,
        url : AJAX_URL,
        context: this,
        beforeSend: function() {
        },
        success: function(response, status, xhr) {
            processResponse(response);
        },
        error: function( jqXHR, textStatus, errorThrown ) {
            //$("#loading-image").addClass("hidden").removeClass("loading-image");
            //console.log("Error!");
        }
    });
};

function serialize(object) {
    let serialize = "";

    for (let item in object) {
        if ( serialize === "" ) {
            serialize += "?" + item + "=" + object[item];
        }
        else {
            serialize += "&" + item + "=" + object[item];
        }
    }

    return serialize;
};

function formatMoney(n, c, d, t) {
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;

    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

function isObject(val) {
    if (val === null) { return false;}
    return ( typeof val === 'object' );
}

class RenderHTML {
    constructor(obj) {
        this.obj = obj;
    }

    render() {
        var html = "";

        if ( isObject( this.obj ) && this.obj.hasOwnProperty("tab") ) {
            if ( typeof this.obj['tab'] === "string" ) {
                var tab = this.obj["tab"].trim().toLowerCase();
                html += "<" + tab + this.renderAttributes() + ">";

                if ( this.obj.hasOwnProperty("text") ) {
                    html += this.obj["text"];
                }

                if (tab !== "input") {
                    html += this.renderChildren() + "</" + tab + ">";
                }
            }
        }

        return html;
    }

    renderAttributes() {
        var html = "";

        if ( this.obj.hasOwnProperty("attributes") ) {
            let attributes = this.obj["attributes"];

            if ( isObject(attributes) ) {
                for (var key in attributes) {
                    if (!attributes.hasOwnProperty(key)) continue;
                    html += ' ' + key + '="' + attributes[key] + '"';
                }
            }
        }

        return html;
    }


    renderChildren() {
        var html = "";

        if ( this.obj.hasOwnProperty("children") ) {
            let children = this.obj["children"];
            if ( Array.isArray(children) ) {
                for (var child of children) {
                    var $child = new RenderHTML(child);
                    html += $child.render();
                }
            }
        }

        return html;
    }
}
