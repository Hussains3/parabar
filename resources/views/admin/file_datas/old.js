$(document).ready(function() {

    // Generate bill no
    const date = new Date();
    const year = date.getFullYear().toString().slice(-2); // Get last two digits of year
    const month = ('0' + (date.getMonth() + 1)).slice(-2); // Get month with leading zero
    const day = ('0' + date.getDate()).slice(-2); // Get day with leading zero
    const randomNum = Math.floor(1000 + Math.random() * 9000); // Generate a random 4-digit number
    const billNo = `BV${year}${month}${day}${randomNum}`;
    $('#bill_no').val(billNo);

    //Make sure all number inputs value should not be lower than 0.00
    $('#fileReciveForm input[type="number"]').on('input', function() {
        if (parseFloat($(this).val()) < 0) {
            $(this).val('0.00');
        }

        calculateTotal();
    });

    // Initial calculation
    calculateTotal();


    $('#remarksTable').on('input', 'tr:last-child input', addRemarksRowIfNeeded);
    $('#receiptableTable tbody').on('input', 'tr:last-child input', addReceiptableRowIfNeeded);
    $('#miscellaneousTable tbody').on('input', 'tr:last-child input', addMiscellaneousRowIfNeeded);



    // recalc when value changes, or a row is removed
    $('#receiptableTable tbody').on('input change', 'input[name="receptable_amounts[]"]', updateReceptableTotalAndPaymentTotal);
    $('#receiptableTable .rowRemove').on('click', updateReceptableTotalAndPaymentTotal); // defer to allow DOM update
    // also in case user programmatically removes row

    $('#miscellaneousTable tbody').on('input change', 'input[name="miscellaneous_amounts[]"]', updateMiscellaneousTotalAndPaymentTotal);
    $('#miscellaneousTable .rowRemove').on('click', updateMiscellaneousTotalAndPaymentTotal); // defer to allow DOM update


    // Initial sync on load
    updateMiscellaneousTotalAndPaymentTotal();
    // Initial sync on load
    updateReceptableTotalAndPaymentTotal();
});


// Watch for change/input/removal in miscellaneousTable amounts and recalc total
function updateMiscellaneousTotalAndPaymentTotal() {
    var miscellaneousTotal = 0;
    $('#miscellaneousTable input[name="miscellaneous_amounts[]"]').each(function() {
        var value = parseFloat($(this).val());
        if (!isNaN(value)) miscellaneousTotal += value;
    });
    $('#miscellaneous_total').val(miscellaneousTotal.toFixed(2));
    calculateTotal(); // recalc payment total as well (as before)
}

// Watch for change/input/removal in receiptableTable amounts and recalc total
function updateReceptableTotalAndPaymentTotal() {
    var receptableTotal = 0;
    $('#receiptableTable input[name="receptable_amounts[]"]').each(function() {
        var value = parseFloat($(this).val());
        if (!isNaN(value)) receptableTotal += value;
    });
    $('#receptable_total').val(receptableTotal.toFixed(2));
    calculateTotal(); // recalc payment total as well (as before)
}

// Calculate total cost
function calculateTotal() {
    let total = 0.00;
    const receptableTotal = $('#receptable_total').val();
    const miscellaneousTotal = $('#miscellaneous_total').val();
    const advance = $('#advance');
    const balance = $('#balance');
    const receptableValue = parseFloat($('#receptable_total').val()) || 0.00;
    const miscellaneousValue = parseFloat($('#miscellaneous_total').val()) || 0.00;
    total += receptableValue;
    total += miscellaneousValue;

    $('#total').val(total.toFixed(2)); // <-- update the Payment Details total


    //Calculating balance and update html
    balance.val($('#total').val() - $('#advance').val());

    //Gte the value of total and make it in word
    $('#totalInWord').val(numberToWords($('#balance').val()));
}

//Calculating dollar to taka
$('#lc_value, #dollar_rate').on('input', function() {
    try {
        const lc_value = parseFloat($('#lc_value').val());
        const dollar_rate = parseFloat($('#dollar_rate').val());

        if (isNaN(lc_value) || isNaN(dollar_rate)) {
            $('#ass_value').val('0.00');
            return;
        }

        const ass_value = lc_value * dollar_rate;
        $('#ass_value').val(ass_value.toFixed(2));
    } catch (error) {
        console.error('Error calculating ass_value:', error);
        $('#ass_value').val('0.00');
    }
});

//Adding new row on remarks table
function addRemarksRowIfNeeded() {
    const $rows = $('#remarksTable tbody tr');
    const $lastRow = $rows.last();
    const $textInput = $lastRow.find('input[type="text"]');
    const $numInput = $lastRow.find('input[type="number"]');
    if (($textInput.val() !== '' || $numInput.val() !== '')) {
        const newRow = `<tr>\n` +
            `<td class="border border-gray-400 px-1 py-[1px] text-left"><input type="text" class="bg-transparent border-none p-0" name="remarks_name[]"></td>` +
            `<td class="border border-gray-400 px-1 py-[1px] relative group"><input type="number" class="text-left bg-transparent border-none p-0 max-w-10" name="remarks_value[]" value="0">
                <button class="text-red-400 cursor-pointer text-base absolute right-2 top-[2px] invisible group-hover:visible" onclick="removeRow(this)"><i class="mdi mdi-delete"></i></button></td>\n` +
            `</tr>`;
        $('#remarksTable').append(newRow);
    }
}

//Adding new row on receiptableTable
function addReceiptableRowIfNeeded() {
    const $rows = $('#receiptableTable tbody tr');
    const $lastRow = $rows.last();
    const $textInput = $lastRow.find('input[type="text"]');
    const $numInput = $lastRow.find('input[type="number"]');
    if (($textInput.val() !== '' || $numInput.val() !== '')) {
        const newRow = `<tr>\n` + `<td class="border border-gray-400 px-1 py-[1px] text-left w-full"><input type="text" class="bg-transparent border-none p-0 w-full"
        name="receptable_descriptions[]" value="-">` +
            `</td>
        <td class="border border-gray-400 px-1 py-[1px] text-center w-full"><input type="text" class="bg-transparent border-none p-0 w-full" name="receptable_numbers[]" value="-"></td>` +
            `
        <td class="border border-gray-400 px-1 py-[1px] text-left w-16"><input type="text" class="bg-transparent border-none p-0 w-full" name="receptable_date[]" value="-"></td>` +
            `<td class="border border-gray-400 px-1 py-[1px] text-right max-w-32 relative group">
                                    <input type="text" class="bg-transparent border-none p-0 w-28"
                                        name="receptable_amounts[]" value="0">
                                        <button class="text-red-400 cursor-pointer text-base absolute right-2 top-[2px] invisible group-hover:visible" onclick="removeRow(this)"><i class="mdi mdi-delete"></i></button>
                                </td>` +
            `</tr>`;
        $('#receiptableTable tbody').append(newRow);
    }
}

//Adding new row on miscellaneousTable
function addMiscellaneousRowIfNeeded() {
    const $rows = $('#miscellaneousTable tbody tr');
    const $lastRow = $rows.last();
    const $textInput = $lastRow.find('input[type="text"]');
    const $numInput = $lastRow.find('input[type="number"]');
    if (($textInput.val() !== '' || $numInput.val() !== '')) {
        const newRow = `<tr>\n` + `<td class="border border-gray-400 px-1 py-[1px] text-left w-full"><input type="text" class="bg-transparent border-none p-0 w-full"
        name="miscellaneous_detailses[]" value="-">` +
            `</td>
        <td class="border border-gray-400 px-1 py-[1px] text-center w-full"><input type="text" class="bg-transparent border-none p-0 w-full" name="miscellaneous_numbers[]" value="-"></td>` +
            `
        <td class="border border-gray-400 px-1 py-[1px] text-left w-16"><input type="text" class="bg-transparent border-none p-0 w-full" name="miscellaneous_dates[]" value="-"></td>` +
            `<td class="border border-gray-400 px-1 py-[1px] text-right max-w-32 relative group">
                                    <input type="text" class="bg-transparent border-none p-0 w-28"
                                        name="miscellaneous_amounts[]" value="0">
                                        <button class="text-red-400 cursor-pointer text-base absolute right-2 top-[2px] invisible group-hover:visible" onclick="removeRow(this)"><i class="mdi mdi-delete"></i></button>
                                </td>` +
            `</tr>`;
        $('#miscellaneousTable tbody').append(newRow);
    }
}







// Table Row Removing
function removeRow(button) {
    var row = button.closest('tr');
    if (row) {
        row.remove();
    }
    updateReceptableTotalAndPaymentTotal();
    updateMiscellaneousTotalAndPaymentTotal();
}

