

function EditRestaraunt(id,user,password)
{
    window.location = "editRestaraunt.php?username=" + user + "&password=" + password + "&id=" + id;
}

function DeleteRestaraunt(id, user, password)
{
    if (confirm("Are you sure you want to delete this entry?")) {
        window.location = "adminRestaraunt.php?username=" + user + "&password=" + password + "&id=" + id + "&type=delete";
    }
}