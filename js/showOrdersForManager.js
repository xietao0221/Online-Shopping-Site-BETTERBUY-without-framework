function categoryOrProduct() {
    var x = document.getElementById("categoryOrProduct");
    if (x.value == "category") {
        document.getElementById('categoryChoose').style.display = "inline";
        document.getElementById('productChoose').style.display = "none";
    } else {
        document.getElementById('categoryChoose').style.display = "none";
        document.getElementById('productChoose').style.display = "inline";
    }
}

function allDateOrSpecific() {
    var x = document.getElementById("allDateOrSpecific");
    if (x.value == "all") {
        document.getElementById('startDate').style.display = "none";
        document.getElementById('endDate').style.display = "none";
    } else {
        document.getElementById('startDate').style.display = "inline";
        document.getElementById('endDate').style.display = "inline";
    }
}

function submitForm() {
    var categoryOrProduct = document.getElementById('categoryOrProduct').value;
    var productChoose = document.getElementById('productChoose').value;
    var categoryChoose = document.getElementById('categoryChoose').value;
    var totalOrQuantity = document.getElementById('totalOrQuantity').value;
    var allDateOrSpecific = document.getElementById('allDateOrSpecific').value;
    var startDate = document.getElementById('startDate').value;
    var endDate = document.getElementById('endDate').value;
    var descendingOrAscending = document.getElementById('descendingOrAscending').value;
    var errMsg = '';

    if (allDateOrSpecific == 'specific') {
        //Start Date
        if (startDate == '') {
            errMsg += 'Start Date: You should input Start Date(valid date).\n';
        } else if (!isDate(startDate)) {
            errMsg += 'Start Date: You should input a valid date.\n';
        }

        //End Date
        if (endDate == '') {
            errMsg += 'End Date: You should input End Date.\n';
        } else if (!isDate(endDate)) {
            errMsg += 'End Date: You should input a valid date.\n';
        }

        if (startDate >= endDate) {
            errMsg += 'Start Date and End Date: End Date should greater than Start Date.\n';
        }
    }

    if (errMsg == '') {
        window.location.href='showOrderResult.php?categoryOrProduct=' + categoryOrProduct
        + '&productChoose=' + productChoose + '&categoryChoose=' + categoryChoose
        + '&totalOrQuantity=' + totalOrQuantity + '&allDateOrSpecific=' + allDateOrSpecific
        + '&startDate=' + startDate + '&endDate=' + endDate + '&descendingOrAscending=' + descendingOrAscending;
        return true;
    } else {
        alert(errMsg);
        return false;
    }
}

function isDate(txtDate)
{
    var currVal = txtDate;
    if(currVal == '')
        return false;

    var rxDatePattern = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/; //Declare Regex
    var dtArray = currVal.match(rxDatePattern); // is format OK?

    if (dtArray == null)
        return false;

    //Checks for mm/dd/yyyy format.
    dtMonth = dtArray[3];
    dtDay= dtArray[5];
    dtYear = dtArray[1];

    if (dtMonth < 1 || dtMonth > 12)
        return false;
    else if (dtDay < 1 || dtDay> 31)
        return false;
    else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
        return false;
    else if (dtMonth == 2)
    {
        var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
        if (dtDay> 29 || (dtDay ==29 && !isleap))
            return false;
    }
    return true;
}

