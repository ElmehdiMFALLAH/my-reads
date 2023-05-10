import $ from 'jquery';

export function storeReadId(id)
{
    sessionStorage.setItem('readId', id);
}

export function deleteRead()
{
    let readId = sessionStorage.getItem('readId');
    
    fetch("/reads/delete/" + readId, {
    method: 'DELETE',
    }).then((response) => {
        console.log(response)
        if (response.status === 200) {
            console.log("Read successfully deleted!")
            $("#deleteModalBody").html("Successfully deleted!");
        } else {
            console.log("Response status : " + response.status);
            $("#deleteModalBody").html("Failed to delete this read!");
        }
    }).catch((error) => {
        console.log(error)
    });
    $("#deleteConfirmButton").hide();
}

export function refresh()
{
    location.reload();
}