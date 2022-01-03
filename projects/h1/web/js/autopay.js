$(document).ready(function () {
    
    function addMonths(date, count) {
        var startDate = date,
        add = parseInt(count),
        day = startDate.replace(/(\d+)\.(\d+)\.(\d+)/,'$1' ),
        month = parseInt(startDate.replace(/(\d+)\.(\d+)\.(\d+)/,'$2' )),
        year = parseInt(startDate.replace(/(\d+)\.(\d+)\.(\d+)/,'$3' ));
        if (month + count >12 )
        {
            year++;
            month = month + count -12 ;
        }
        else
        {
            month = month + count ;
        }
        if (month < 10)
        {
            month = '0' + month;
        }
        return day + '.' + month + '.' + year;
    }    
    
    $('body').on('click', '.generate-row', function (e) {
        if ($('#autopay-summaautopay').val() == '' || $('#autopay-countdetails').val() == '' || typeof $('#autopay-countdetails').val() == 'undefined' || typeof $('#autopay-summaautopay').val() == 'undefined')
        {
            alert('No value in sum or count fields');
            return false;
            exit;
        }
        
        if($('#autopay-startdate').val() != '' && typeof $('#autopay-startdate').val() != 'undefined' )
        {
            var startDate = addMonths($('#autopay-startdate').val(),0);
        }
        
        e.preventDefault();
        var numberOfRows=$('#autopay-countdetails').val(),
            rowSum = Math.round($('#autopay-summaautopay').val() / numberOfRows),
            count = $('.js-clone-row[data-type=AutopayDetails]').length,
            sumAfterCount = rowSum * numberOfRows;

        if (parseInt(numberOfRows) == parseInt(count))
        {
            return false;
            exit;
        }
            
        $('#autopaydetails-0-pay_sum').val(rowSum);
        $('#autopaydetails-0-pay_date').val(startDate);

        do
        {
        var type = $(this).data('type'),
            cloneRows = $('.js-clone-row[data-type=AutopayDetails]'),
            clone = cloneRows.first().clone(),
            count = cloneRows.length;

            clone.find('div.form-group').each(function(){
                var cl = $(this).prop('class');
                $(this).prop('class',cl.replace(/(\w+\s)(\w+\-)(\w+\-)(\d+)(\-\w+)/, '$1'+'$2'+'$3'+count+'$5'));
            });

            clone.find(':text').each(function(){
            var parrent = $(this).parent().prop('class'),
                newParrent = parrent.replace(/(\w+\-\w+\s)(\w+\-)(\w+\-)(\d+)(\-\w+)\s(\w+)/, '$2'+'$3'+count+'$5');
//            console.log(newParrent);
            var name = $(this).prop('name'),
                id = $(this).prop('id'),
                newName = name.replace(/(\w+\[)(\d+)(\]\[\w+\])/, '$1'+count+'$3'),
                newId = id.replace(/(\w+\-)(\d+)(\-\w+)/, '$1'+count+'$3');
                console.log(newName);
            $(this).prop('name', newName);
            $(this).prop('id', newId);
            
            if (newId.replace(/(\w+\-)(\d+)(\-\w+)/, '$3') == '-pay_sum')
            {
                $(this).val(rowSum);
            }
            if (newId.replace(/(\w+\-)(\d+)(\-\w+)/, '$3') == '-pay_date' && $('#autopay-startdate').val() != '' && typeof $('#autopay-startdate').val() != 'undefined')
            {
                var monthDate = addMonths(startDate, count);
                $(this).val(monthDate);
            }

        var attribute = {
        'id': newId,
        'name': newName.replace(/(\w+)(\[\d+\])\[(\w+)\]/,'$2'+'$3'),
        'container': '.'+newParrent,
        'input': '#' + newId,
        'error': '.help-block.help-block-error',
        'enableAjaxValidation': true,
        'validateOnType': true
        };
        console.log(attribute);
        $('#autopay-form').yiiActiveForm('add', attribute);        


        });
//         clone.find('.js-row-id').text(count + 1);
        cloneRows.last().after(clone);
        }  while (count < numberOfRows-1)
        
        $('#autopay-summaautopay').val(sumAfterCount);
        $('.generate-row').hide();
        
    });
    
});