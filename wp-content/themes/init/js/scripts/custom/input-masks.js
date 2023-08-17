HTMLElement.prototype.phoneMask = function() {
    let mask = new IMask(this, {
        mask: '+{7} (000) 000-00-00',
        lazy: this.classList.contains('hide-mask'),
        placeholderChar: '_'
    })

    mask.type = 'phone'
    this.mask = mask
}

HTMLElement.prototype.timeMask = function() {
  let mask = new IMask(this, {
    mask: 'H:M',
    lazy: false,
    placeholderChar: '_',
    blocks: {
      H: {
        mask: IMask.MaskedRange,
        from: 0,
        to: 23,
        maxLength: 2,
        validate: function(value, masked) {
          return (value >= 0 && value <= 99);
        },
        overwrite: true,
      },
      M: {
        mask: IMask.MaskedRange,
        from: 0,
        to: 59,
        maxLength: 2,
        overwrite: true,
      }
    }
  });

  mask.type = 'time';
  this.mask = mask;

  const isMobileDevice = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

  const inputEvent = isMobileDevice ? 'input' : 'keydown';

  this.addEventListener(inputEvent, function(e) {
    const inputValue = this.mask.unmaskedValue;
    const selectionStart = this.selectionStart;

    if (inputEvent === 'keydown') {
      if (inputValue.length === 0 && e.key >= 0 && e.key <= 9) {
        const firstDigit = parseInt(e.key, 10);
        let newValue = e.key.toString();

        if (firstDigit >= 3 && firstDigit <= 9) {
          newValue = '0' + newValue;
        }

        this.mask.value = newValue;
        this.mask.updateValue();
        this.setSelectionRange(2, 2);
        e.preventDefault();
      }
    } else if (inputEvent === 'input' && isMobileDevice) {
      if (inputValue.length === 0 && e.data >= 3 && e.data <= 9) {
        const firstDigit = parseInt(e.data, 10);
        const newValue = '0' + firstDigit.toString();

        this.mask.value = newValue;
        this.mask.updateValue();
        this.setSelectionRange(2, 2);


      }
    }
  });
};



const orderTimeInput = document.getElementById('order_time');
if (typeof(orderTimeInput) != 'undefined' && orderTimeInput != null)
{
  orderTimeInput.timeMask();
}









































HTMLElement.prototype.priceMask = function() {
    let mask = new IMask(this, {
        mask: Number,
        min: 0,
        max: 10000000,
        thousandsSeparator: ' '
    })

    mask.type = 'price'
    this.mask = mask
}

HTMLElement.prototype.dateMask = function() {
    let mask = new IMask(this, {
        mask: Date,
        lazy: false,
        placeholderChar: '_'
    })

    mask.type = 'date'
    this.mask = mask
    this.datepicker = new Datepicker(this, {
        format: 'dd.mm.yyyy',
        language: 'ru'
    })

    console.log(this.datepicker);
}

HTMLElement.prototype.slugMask = function() {
    let mask = new IMask(this, {
        mask: /^\w+$/,
    })

    mask.type = 'slug'
    this.mask = mask
}

let priceInputs = document.querySelectorAll('.price-mask')
if(priceInputs.length) {
    for(let input of priceInputs) {
        input.priceMask()
    }
}

let dateInputs = document.querySelectorAll('.date-input, .date-mask')
if(dateInputs.length) {
    for(let input of dateInputs) {
        input.dateMask()
    }
}

let slugInputs = document.querySelectorAll('.slug-mask')
if(slugInputs.length) {
    for(let input of slugInputs) {
        input.slugMask()
    }
}

let timeInputs = document.querySelectorAll('.time-mask')
if(timeInputs.length) {
    for(let input of timeInputs) {
        input.timeMask()
    }
}

let phoneInputs = document.querySelectorAll('.phone-mask')
if(phoneInputs.length) {
    for(let input of phoneInputs) {
        input.phoneMask()
    }
}