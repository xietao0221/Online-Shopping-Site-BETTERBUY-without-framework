function checkRegister() {
    var inputEmail = document.forms['customerRegisterForm']['inputEmail'].value;
    var inputPassword = document.forms['customerRegisterForm']['inputPassword'].value;
    var inputConfirmPassword = document.forms['customerRegisterForm']['inputConfirmPassword'].value;
    var inputGender = document.forms['customerRegisterForm']['inputGender'].value;
    var inputFirstName = document.forms['customerRegisterForm']['inputFirstName'].value;
    var inputLastName = document.forms['customerRegisterForm']['inputLastName'].value;
    var inputAddressLine1 = document.forms['customerRegisterForm']['inputAddressLine1'].value;
    var inputAddressLine2 = document.forms['customerRegisterForm']['inputAddressLine2'].value;
    var inputCity = document.forms['customerRegisterForm']['inputCity'].value;
    var inputState = document.forms['customerRegisterForm']['inputState'].value;
    var inputZipCode = document.forms['customerRegisterForm']['inputZipCode'].value;
    var inputTelephoneNumber = document.forms['customerRegisterForm']['inputTelephoneNumber'].value;
    var inputCardType = document.forms['customerRegisterForm']['inputCardType'].value;
    var inputCardNumber = document.forms['customerRegisterForm']['inputCardNumber'].value;
    var inputExpirationMonth = document.forms['customerRegisterForm']['inputExpirationMonth'].value;
    var inputExpirationYear = document.forms['customerRegisterForm']['inputExpirationYear'].value;
    var inputCVV = document.forms['customerRegisterForm']['inputCVV'].value;

    var regexLetterNumber = /^\w+$/;
    var regexLetter = /^[a-zA-Z]+$/;
    var regexNumber = /^[0-9]*[1-9][0-9]*$/;
    var regexText = /[A-Za-z0-9 _.,!"'/$]*/;
    var regexFloat = /^(0(\.\d+)?|1(\.0+)?)$/;
    var regexEmail = /\S+@\S+\.\S+/;
    var errMsg = '';

    //Email
    document.getElementById('inputEmailErr').innerHTML = '';
    if (inputEmail == '') {
        errMsg = 'Required.';
        document.getElementById('inputEmailErr').innerHTML = errMsg;
    } else if (!inputEmail.match(regexEmail)) {
        errMsg = 'Invalid Email.';
        document.getElementById('inputEmailErr').innerHTML = errMsg;
    }

    //password
    document.getElementById('inputPasswordErr').innerHTML = '';
    if (inputPassword == '') {
        errMsg = 'Required.';
        document.getElementById('inputPasswordErr').innerHTML = errMsg;
    } else if (!inputPassword.match(regexLetter)) {
        errMsg = 'Only Letters.';
        document.getElementById('inputPasswordErr').innerHTML = errMsg;
    } else if (inputPassword.length >= 10) {
        errMsg = 'Too long';
        document.getElementById('inputPasswordErr').innerHTML = errMsg;
    }

    //password confirm
    document.getElementById('inputConfirmPasswordErr').innerHTML = '';
    if (inputConfirmPassword == '') {
        errMsg = 'Required.';
        document.getElementById('inputConfirmPasswordErr').innerHTML = errMsg;
    } else if (inputConfirmPassword != inputPassword) {
        errMsg = 'No Match';
        document.getElementById('inputConfirmPasswordErr').innerHTML = errMsg;
    }

    //Gender
    document.getElementById('inputGenderErr').innerHTML = '';
    if (inputGender == '') {
        errMsg = 'Required.';
        document.getElementById('inputGenderErr').innerHTML = errMsg;
    }

    //First Name
    document.getElementById('inputFirstNameErr').innerHTML = '';
    if (inputFirstName == '') {
        errMsg = 'Required.';
        document.getElementById('inputFirstNameErr').innerHTML = errMsg;
    } else if (!inputFirstName.match(regexLetter)) {
        errMsg = 'Only Letters.';
        document.getElementById('inputFirstNameErr').innerHTML = errMsg;
    } else if (inputFirstName.length >= 10) {
        errMsg = 'Too long';
        document.getElementById('inputFirstNameErr').innerHTML = errMsg;
    }

    //Last Name
    document.getElementById('inputLastNameErr').innerHTML = '';
    if (inputLastName == '') {
        errMsg = 'Required.';
        document.getElementById('inputLastNameErr').innerHTML = errMsg;
    } else if (!inputLastName.match(regexLetter)) {
        errMsg = 'Only Letters.';
        document.getElementById('inputLastNameErr').innerHTML = errMsg;
    } else if (inputLastName.length >= 10) {
        errMsg = 'Too long';
        document.getElementById('inputLastNameErr').innerHTML = errMsg;
    }

    //Address Line 1
    document.getElementById('inputAddressLine1Err').innerHTML = '';
    if (inputAddressLine1 == '') {
        errMsg = 'Required.';
        document.getElementById('inputAddressLine1Err').innerHTML = errMsg;
    } else if (!inputAddressLine1.match(regexText)) {
        errMsg = 'Invalid.';
        document.getElementById('inputAddressLine1Err').innerHTML = errMsg;
    } else if (inputAddressLine1.length >= 20) {
        errMsg = 'Too long';
        document.getElementById('inputAddressLine1Err').innerHTML = errMsg;
    }

    //Address Line 2
    document.getElementById('inputAddressLine2Err').innerHTML = '';
    if (inputAddressLine2 == '') {
        errMsg = 'Required.';
        document.getElementById('inputAddressLine2Err').innerHTML = errMsg;
    } else if (!inputAddressLine2.match(regexText)) {
        errMsg = 'Invalid.';
        document.getElementById('inputAddressLine2Err').innerHTML = errMsg;
    } else if (inputAddressLine2.length >= 20) {
        errMsg = 'Too long';
        document.getElementById('inputAddressLine2Err').innerHTML = errMsg;
    }

    //City
    document.getElementById('inputCityErr').innerHTML = '';
    if (inputCity == '') {
        errMsg = 'Required.';
        document.getElementById('inputCityErr').innerHTML = errMsg;
    } else if (!inputCity.match(regexText)) {
        errMsg = 'Invalid.';
        document.getElementById('inputCityErr').innerHTML = errMsg;
    } else if (inputCity.length >= 20) {
        errMsg = 'Too long';
        document.getElementById('inputCityErr').innerHTML = errMsg;
    }

    //State
    document.getElementById('inputStateErr').innerHTML = '';
    if (inputState == '') {
        errMsg = 'Required.';
        document.getElementById('inputStateErr').innerHTML = errMsg;
    } else if (!inputState.match(regexText)) {
        errMsg = 'Invalid.';
        document.getElementById('inputStateErr').innerHTML = errMsg;
    } else if (inputState.length >= 20) {
        errMsg = 'Too long';
        document.getElementById('inputStateErr').innerHTML = errMsg;
    }

    //Zip Code
    document.getElementById('inputZipCodeErr').innerHTML = '';
    if (inputZipCode == '') {
        errMsg = 'Required.';
        document.getElementById('inputZipCodeErr').innerHTML = errMsg;
    } else if (!inputZipCode.match(regexNumber)) {
        errMsg = 'Only Numbers.';
        document.getElementById('inputZipCodeErr').innerHTML = errMsg;
    } else if (inputZipCode.length > 5) {
        errMsg = 'Too long';
        document.getElementById('inputZipCodeErr').innerHTML = errMsg;
    }

    //Telephone
    document.getElementById('inputTelephoneNumberErr').innerHTML = '';
    if (inputTelephoneNumber == '') {
        errMsg = 'Required.';
        document.getElementById('inputTelephoneNumberErr').innerHTML = errMsg;
    } else if (!inputTelephoneNumber.match(regexNumber)) {
        errMsg = 'Only Numbers.';
        document.getElementById('inputTelephoneNumberErr').innerHTML = errMsg;
    } else if (inputTelephoneNumber.length > 11) {
        errMsg = 'Too long';
        document.getElementById('inputTelephoneNumberErr').innerHTML = errMsg;
    }

    //Credit Card Type
    document.getElementById('inputCardTypeErr').innerHTML = '';
    if (inputCardType == '') {
        errMsg = 'Required.';
        document.getElementById('inputCardTypeErr').innerHTML = errMsg;
    }

    //Card Number
    document.getElementById('inputCardNumberErr').innerHTML = '';
    if (inputCardNumber == '') {
        errMsg = 'Required.';
        document.getElementById('inputCardNumberErr').innerHTML = errMsg;
    } else if (!inputCardNumber.match(regexNumber)) {
        errMsg = 'Only Numbers.';
        document.getElementById('inputCardNumberErr').innerHTML = errMsg;
    } else if (inputCardNumber.length > 16) {
        errMsg = 'Invalid';
        document.getElementById('inputCardNumberErr').innerHTML = errMsg;
    }

    //Month
    document.getElementById('inputExpirationDateErr').innerHTML = '';
    if (inputExpirationMonth == '' || inputExpirationYear == '') {
        errMsg = 'Required.';
        document.getElementById('inputExpirationDateErr').innerHTML = errMsg;
    }

    //CVV
    document.getElementById('inputCVVErr').innerHTML = '';
    if (inputCVV == '') {
        errMsg = 'Required.';
        document.getElementById('inputCVVErr').innerHTML = errMsg;
    } else if (inputCVV.length != 3) {
        errMsg = 'Invalid';
        document.getElementById('inputCVVErr').innerHTML = errMsg;
    } else if (!inputCVV.match(regexNumber)) {
        errMsg = 'Only Numbers.';
        document.getElementById('inputCVVErr').innerHTML = errMsg;
    }

    if (errMsg == '') {
        return true;
    } else {
        alert('You need to check your input data.');
        return false;
    }
}