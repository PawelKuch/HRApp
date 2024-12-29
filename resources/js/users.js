document.addEventListener("DOMContentLoaded", function (){
    let submitFormBtn = document.querySelector("#submit-form-button");
    let createUserForm = document.querySelector("#create-user-form")
    submitFormBtn.addEventListener("click", function (){
        createUserForm.submit();
    });
});
