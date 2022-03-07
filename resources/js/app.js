/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });

function closeNominal() {
    $('.close-nominal').on('click', function(event) {
        $(event.target).parent('.block-nominal').remove();
        calculateTotal();
    });
}
function updateBlock() {
    $("select.nominal").on('change', function(event) {
        calculateTotal();
    });
    $("input.quantity").on('change keyup paste', function(event) {
        calculateTotal();
    });
}

function calculateTotal() {
    var total = 0;

    $('.block-nominal').each((index, element) => {
        var nominal = $('#nominal', element).val();

        if ($('#nominal', element).hasClass('centimes')) {
            nominal = nominal / 100;
        }
        var quantity = $('#quantity', element).val();
        var subtotal = nominal * quantity;
        total += subtotal;

        $('.subtotal', element).html(subtotal);
    });

    $('.total').html(total);
}

$( document ).on('ready', function() {
    $('#datepicker').datetimepicker({
        format: 'DD/MM/YYYY'
    });

    $('.add-nominal').on('click', function(event) {

        var block = $(event.target).data('block');
        var lastnumber = $(event.target).siblings('.block-nominal-wrapper').children('.block-nominal').last().data('number') + 1;

        var nominals = null;
        var nominals = null;
        var centimesClass = '';
    
        if (block == 'billets') {
            nominals = billetsNominal;
        }
        if (block == 'pieces') {
            nominals = piecesNominal;
        }
        if (block == 'centimes') {
            nominals = centimesNominal;
            centimesClass = 'centimes';
        }

        var markup = `
            <div class="block-nominal" data-number="`+lastnumber+`">
                <div class="d-inline-block col-md-5">
                    <label for="nominal" class="col-md-4 col-form-label text-md-end">Nominal</label>

                    <div class="col-md-6">
                        <select name="`+block+`[`+lastnumber+`][nominal]" id="nominal" class="form-control nominal `+centimesClass+`">`;
                        
                        nominals.forEach(element => {
                            markup += (`<option value="`+element+`" >`+element+`</option>`)
                        });
        markup +=           `
                        </select>
                    </div>
                </div>
                <div class="d-inline-block col-md-5">
                    <label for="quantity" class="col-md-4 col-form-label text-md-end">Quantité</label>

                    <div class="col-md-6">
                        <input id="quantity" type="number" class="form-control quantity `+centimesClass+`" name="`+block+`[`+lastnumber+`][quantity]" value="">
                    </div>
                </div>
                <span class="subtotal">0</span>€
                <span class="close-nominal">X</span>
            </div>
        `;
        
        $(event.target).siblings('.block-nominal-wrapper').append(markup);
        closeNominal();
        calculateTotal();
        updateBlock();
    });

    closeNominal();
    calculateTotal();
    updateBlock();

    $('.btn-danger').on('click', function(event) {
        if (!confirm('Vous êtes sûr?')) {
            event.preventDefault();
            event.stopPropagation();
        }
    });
});


