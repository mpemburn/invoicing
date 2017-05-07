/**
 * Numeric.js
 *
 * Simple number-based utility class
 */

var Numeric = {
    toDollar: function(amount) {
        return '$' + this.numberFormat(amount, 2, '.', ',') ;
    },
    numberFormat: function (number, decimals, dec_point, thousands_sep) {
        number = isNaN(number * 1) ? 0 : number * 1;
        var str = number.toFixed(decimals ? decimals : 0).toString().split('.');
        var parts = [];
        for (var i = str[0].length; i > 0; i -= 3) {
            parts.unshift(str[0].substring(Math.max(0, i - 3), i));
        }
        str[0] = parts.join(thousands_sep ? thousands_sep : ',');

        return str.join(dec_point ? dec_point : '.');
    }
}
