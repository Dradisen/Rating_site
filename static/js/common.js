function confirm_delete(){
    if (confirm("Удалить запись?")){
    return true;

    }else {
        (event || window.event).preventDefault()
        return false;
    }
}