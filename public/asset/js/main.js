function formValidate(element) {
	var form = $(element);
	form.validate();
	return form.valid();
}
$.extend($.validator, {
	messages: {
		required: "Campo requerido.",
		remote: "Favor de revisar la información.",
		email: "Favor de ingresar una cuenta de email valida.",
		url: "Favor de ingresar un URL valida.",
		date: "Favor de ingresa una fecha valida.",
		dateISO: "Favor de ingresa una fecha valida ( ISO ).",
		number: "Favor de ingresar un número valido.",
		digits: "Favor de ingresar sólo digitos.",
		creditcard: "Número de tarjeta de crédito invalido.",
		equalTo: "El valor no coincide.",

	},

	defaults: {
		messages: {},
		groups: {},
		rules: {},
		errorElementClass: 'is-invalid',
		errorClass: 'error invalid-feedback',
		//errorElement: 'span', //default input error message container
		focusCleanup: false,
		focusInvalid: true,
		errorContainer: $([]),
		errorLabelContainer: $([]),
		doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
		onsubmit: true,
		ignore: ":hidden",
		ignoreTitle: false,
		onfocusin: function (element) {
			this.lastActive = element;

			// Hide error label and remove error class on focus if enabled
			if (this.settings.focusCleanup) {
				if (this.settings.unhighlight) {
					this.settings.unhighlight.call(this, element, this.settings.errorClass, this.settings.validClass);
				}
				this.hideThese(this.errorsFor(element));
			}
		},
		onfocusout: function (element) {
			if (!this.checkable(element) && (element.name in this.submitted || !this.optional(element))) {
				this.element(element);
			}
		},
		onkeyup: function (element, event) {
			// Avoid revalidate the field when pressing one of the following keys
			// Shift       => 16
			// Ctrl        => 17
			// Alt         => 18
			// Caps lock   => 20
			// End         => 35
			// Home        => 36
			// Left arrow  => 37
			// Up arrow    => 38
			// Right arrow => 39
			// Down arrow  => 40
			// Insert      => 45
			// Num lock    => 144
			// AltGr key   => 225
			var excludedKeys = [
				16, 17, 18, 20, 35, 36, 37,
				38, 39, 40, 45, 144, 225
			];

			if (event.which === 9 && this.elementValue(element) === "" || $.inArray(event.keyCode, excludedKeys) !== -1) {
				return;
			} else if (element.name in this.submitted || element === this.lastElement) {
				this.element(element);
			}
		},
		onclick: function (element) {
			// click on selects, radiobuttons and checkboxes
			if (element.name in this.submitted) {
				this.element(element);
				// or option elements, check parent select in that case
			} else if (element.parentNode.name in this.submitted) {
				this.element(element.parentNode);
			}
		},
		highlight: function (element, required) {
			$(element).addClass('is-invalid');
			if (element.type === "radio") {
				this.findByName(element.name).addClass(errorClass).removeClass(validClass);
			} else {
				// $( element ).removeClass( errorClass ).addClass( validClass );
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
			}
		},
		unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass('is-invalid');
		},		
		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.hasClass("select2")) {
				var element_select2 = $(element).siblings('.select2-container');
				error.insertAfter(element_select2); // input with select2
			} else {
				error.insertAfter(element); // for other inputs, just perform default behavior
			}
		},
		success: function (label) {
			label.addClass('valid') // mark the current input as valid and display OK icon
				.closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
		},

	},


});

let today = new Date();
let date = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();


$('.input-group.date.hoyant').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    daysOfWeekDisabled: [0,6],
    endDate: date,
});

$('.input-group.date.hoydes').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    daysOfWeekDisabled: [0,6],
    startDate: date,
});

$('.input-group.date.hoy').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    daysOfWeekDisabled: [0,6],
    startDate: date,
    endDate: date,
});

$('.input-group.date').datepicker({
    format: "dd/mm/yyyy",
    language: "es",
    daysOfWeekDisabled: [0,6],
});

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}
