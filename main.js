function handleClick(event)
{
    if (event.target != event.currentTarget)
    {
        // var clickedItem = event.target.id;
        // value = document.getElementById(clickedItem).value;
        
        // if (value == "Subscribe")
        // {
        //     document.getElementById(clickedItem).value = "Unsubscribe";
        // }
        // if (value == "Unsubscribe")
        // {
        //     document.getElementById(clickedItem).value = "Subscribe";
        // }
    }

    event.stopPropagation();
}