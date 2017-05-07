var Currency = {
    locale: 'us',
    currency: 'usd',
    minDigits: 2,
    maxDigits: 2,
    options: {},
    formatter: null,
    toDollar: function (amount) {
        this._setOptions({}); // Use defaults
        return this.formatter.format(amount)
    },
    toEuro: function (amount) {
        this._setOptions({
            locale: 'de',
            currency: 'eur'
        }); // Use defaults
        return this.formatter.format(amount)
    },
    _setOptions: function (options) {
        $.extend(this, options);
        this.options = {
            style: 'numeric',
            currency: this.currency,
            minimumFractionDigits: this.minDigits,
            maximumFractionDigits: this.maxDigits
        };
        this.formatter = new Intl.NumberFormat(this.locale, this.options);
    }
}

