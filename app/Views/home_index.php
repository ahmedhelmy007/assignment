<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<h1>PayTabs Assignment</h1>
<div style="font-size: larger; font-weight: bolder;">
    <em>Assumptions:</em>
    <ul>
        <li>Each time an option in a parent category is selected, the child category list options will be cleared</li>
        <li>Once an option in parent category list that has no child options is selected, a couple of child options will be created for it in DB</li>
        <li>Each time you reach this page only the high level categories list will be shown if there is any in DB. To view its any category sub-categories you have to click it</li>
    </ul>
</div>
<br><br><br>
<div id="container" style="border: 1px solid black; min-height: 100px;">

<?php if (! empty($rootCategories) && is_array($rootCategories)) : ?>

    List #0<select id="0" class="category_select">
        <option value=""></option>
    <?php foreach ($rootCategories as $category_item): ?>
        <option value="<?= esc($category_item['id']); ?>"><?= esc($category_item['name']); ?></option>
    <?php endforeach; ?>
    </select>
<?php else: ?>
    <div style="font-size: larger; font-weight: bolder;">No root categories found</div>
    <a href="createrootcat">press to create a root category</a>
<?php endif ?>
</div>
<script >

    var currentSelect= null;
    $(document).ready(function(){

        $(document).on('change', ".category_select", function(){
            //attempt to get id of children of current category list selected item
            parent_id= $(this).attr("id");
            var currentSelect= parent_id;
            child_list_id= eval(parseInt(parent_id)+1);
            //if selected option is not empty then proceed
            if( $(this).val() != '') {
                if( $('#'+child_list_id).length == 0) {
                    //if not created yet, then create the child list to be filled with returned children shortly
                    $("<div>List #"+child_list_id+"<select class='category_select' id='"+child_list_id+"' /><option value=''></option></div>")
                        .appendTo("#container");
                }else {
                    //child list exists, then clear its current options to be filled with the selected option from parent list
                    $('#'+child_list_id).empty();
                    $('#'+child_list_id).append($("<option value=''></option>"));
                }

                //now hit server-side to either fetch elements of the selected element or to create some new dummy of them
                request= $.ajax({
                    type: "GET",
                    dataType: " json",
                    url: "getchildren/"+$(this).val(),
                    cache: false
                });

                request.done( function (response)
                {
                    parent_id= currentSelect;
                    child_list_id= eval(parseInt(parent_id)+1);
                    $.each(response, function ( childCatId, childCatName ) {
                        $('#'+child_list_id).append($('<option>', {
                            value: childCatId,
                            text: childCatName
                        }));
                    });
                });

                request.fail( function (jqXHR, textStatus) {
                    if(jqXHR.status == 403){
                        //do stuff
                    }
                });

            }

        });
    });
</script>
