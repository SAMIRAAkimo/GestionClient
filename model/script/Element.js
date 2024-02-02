
var urls_district = "./model/php/districtDAO.php";



toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

var Toast = Swal.mixin({
    toast: true,
    position: 'top-start',
    showConfirmButton: false,
    showCloseButton: true,
    cancelButtonAriaLabel: 'Thumbs down',
    timer: 5000
});

/******************************database connection function*******************************/



/******************************database connection function*******************************/

var clearAllForm = function(FormName) {
    $('#' + FormName)[0].reset();
}

var clearOnField = function(field) {

    var type = $("." + field).get(0).tagName;

    type = type.toLowerCase();

    console.log(type);

    switch (type) {
        case 'password':
            $('.' + field).val('');
            console.log("isPassword");
            break;
        case 'select-multiple':
            $('.' + field).html('');
            $('.' + field).trigger('change');
            console.log("isSelect");
            break;
        case 'select':
            $('.' + field).find('option:not(:first)').remove();;
            break;
        case 'text':
            $('.' + field).val('');
            console.log("isFieldText");
            break;
        case 'textarea':
            $('.' + field).val('');
            console.log("isTextArea");
            break;
        case 'checkbox':
            $('.' + field).checked = false;
            break;
        case 'radio':
            $('.' + field).checked = false;
            break;
    }

}

var clearTable = function() {
    $('.table tbody').empty();
    $('.table').DataTable().clear();
    $('.table').DataTable().destroy();
}

var loadYear = function(AnneeDeb, year_select) {

    var fullDate = new Date();
    var item = '<option value="" selected disabled>Année</option>';
    console.log(fullDate.getFullYear());
    for (var i = fullDate.getFullYear(); i >= AnneeDeb; i--) {

        item += '<option value="' + i + '">' + i + '</option>'
        console.log(i);
        var partYear = fullDate.getYear();

    }

    $("." + year_select).html(item);
}

var loadMonth = function(month_select) {

    var theMonths = ["Janvier", "Fevrier", "Mars", "Avril", "Mai",
        "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"
    ];
    var item = '<option value="" selected disabled>Mois</option>';
    var compteur = 1;
    for (i = 0; i < 12; i++) {
        var mois = '' + compteur;

        if (compteur < 10)
            mois = '0' + (compteur);
        item += '<option value="' + mois + '">' + theMonths[i] + '</option>';
        compteur++;
    }

    $("." + month_select).html(item);
}

var loadMonthWithCombo = function(month_select) {

    var theMonths = ["Janvier", "Fevrier", "Mars", "Avril", "Mai",
        "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"
    ];
    var item = '<option value="" selected disabled>Mois</option>';
    var compteur = 1;
    for (i = 0; i < 12; i++) {
        var mois = '' + compteur;

        if (compteur < 10)
            mois = '0' + (compteur);
        item += '<option value="' + mois + '">' + theMonths[i] + '</option>';
        compteur++;
    }

    month_select.html(item);
}

var getMonthName = function(moisEntier) {
    var theMonths = ["Janvier", "Fevrier", "Mars", "Avril", "Mai",
        "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"
    ];
    return theMonths[parseInt(moisEntier)];
}

var onlyNumberAcceptField = function(evt, element) {
    //Check Charater
    var charCode = (evt.which) ? evt.which : event.keyCode

    if ((charCode != 45 || $(element).val().indexOf('-') != -1) && // Check minus and only once.
        (charCode != 46 || $(element).val().indexOf('.') != -1) && // Check dot and only once.
        (charCode < 48 || charCode > 57))
        return false;

    if (this.value) {
        this.value = this.value.replace(/ /g, '');
        var number = this.value;
        this.value = number.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }
    return true;
}

var showMessage = function(text) {
    $.confirm({
        title: 'Message',
        content: text,
        type: 'red',
        typeAnimated: true,
        theme: 'modern', // 'material', 
        buttons: {
            close: {
                text: "OK",
                function() {

                }
            }
        }
    });
}

var showWarning = function(text) {
    $(document).Toasts('create', {
        class: 'bg-warning',
        title: 'Warning',
        //      subtitle: 'Arrêt du processus',
        body: text
    })
}

var showWarningWal = function(text) {
    Toast.fire({
        icon: 'warning',
        title: text
    })
}

var showSuccedWal = function(text) {
    Toast.fire({
        icon: 'success',
        title: text
    })
}

var showInfosWal = function(text) {
    Toast.fire({
        icon: 'info',
        title: text
    })
}

var showErrorWal = function(text) {
    Toast.fire({
        icon: 'error',
        title: text
    })
}

var removeAllComaLastString = function(text) {
    return text.replace(/,(\s+)?$/, '');
}

const myFunction = (inputName, tableName) => {
    const trs = document.querySelectorAll('#' + tableName + ' tr:not(.header)');
    const filter = document.querySelector('#' + inputName + '').value;
    const regex = new RegExp(filter, 'i');
    const isFoundInTds = (td) => regex.test(td.innerHTML);
    const isFound = (childrenArr) => childrenArr.some(isFoundInTds);
    const setTrStyleDisplay = ({ style, children }) => {
        style.display = isFound([...children]) ? '' : 'none';
    };

    trs.forEach(setTrStyleDisplay);
};



var filterTable = function(inputName, tableName) {




    //
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById(inputName);

    if (input && table) {

        filter = input.value.toUpperCase();
        table = document.getElementById(tableName);
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

    }
}

var filterSelect = function(input, select) {

    console.log("NotPublishedSelectFilter keyup");
    var filterText = $("#" + input).val();
    filterText = filterText.toLowerCase();
    console.log("filterText: " + filterText);
    var allOptions = $('#' + select).find('option');
    allOptions.each(function(i, e) {
        console.log(i);

        var text = $(this).text().toLowerCase();

        if (text.indexOf(filterText) !== -1) {
            $(this).show();
            console.log("show");
        } else {
            $(this).hide();
            console.log("hide");
        }
    });

}

//remove duplicate column datatable
function hasTabledit(table) {
    return $('tbody tr:first td:last > div', table).hasClass("tabledit-toolbar");
}

function getUniqueValues(array, key) {
    var result = new Set();
    array.forEach(function(item) {
        if (item.hasOwnProperty(key)) {
            result.add(item[key]);
        }
    });
    return result;
}