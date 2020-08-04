const setAlert = (properties) =>{
    if(properties.hasOwnProperty('title')){
        $("#alert-title").val(properties.title);
    }
    if(properties.hasOwnProperty('message')){
        $("#alert-message").val(properties.message);
    }
    if(properties.hasOwnProperty('type')){
        $("#alert-type").val(properties.type);
    }
    if(properties.hasOwnProperty('timer')){
        $("#alert-timer").val(properties.timer);
    }
}
const setAlertTitle = (title) => {
    $("#alert-title").val(title);
}
const setAlertMessage = (message) => {
    $("#alert-message").val(message);
}
const setAlertType = (type) => {
    $("#alert-type").val(type);
}
const setAlertTimer = (timer) => {
    $("#alert-timer").val(timer);
}
const clearAlert = () => {
    $("#alert-title").val("");
    $("#alert-message").val("");
    $("#alert-type").val("");
    $("#alert-timer").val("");
}