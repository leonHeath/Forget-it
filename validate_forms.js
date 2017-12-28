function password_check(id_1, id_2){
    var value_1 = document.getElementById(id_1).value;
    var value_2 = document.getElementById(id_2).value;
    if(value_1 === value_2){
        document.getElementById(id_2).className = "valid";
        console.log("Valid input");
    }
    else{
        document.getElementById(id_2).className = "invalid";
        console.log("Invalid input");
    }
}

//Do all tests here
function validate_reg() {
    password_check('reg_pass_1', 'reg_pass_2');
}