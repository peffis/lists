
function save() {
    listd.version += 1;

    $.post( 'save.php', 
	    'data=' + encodeURIComponent(JSON.stringify(listd)),
	    function() {})
	.success(function() {})
	.error(function() {
		   listd.version = 0;
		   alert("Version mismatch\nPlease reload page before\nnext update")
	       })
	.complete(function() {});
    
}

function deleteList(listId) {
    var new_lists = [];
  
    if (confirm("Do you really want to remove the list?")) {

       for (i in listd.lists) {
	   if (listd.lists[i].id != listId) {
	       new_lists.push(listd.lists[i]);
	   }
       }

       listd.lists = new_lists;
       generateListTables();
       save();
    }
}

function generateId() {
    return 'id_' + new Date().getTime();
}

function addItem(listId, itemstr) {
    for (i in listd.lists) {
	if (listd.lists[i].id == listId) {
	    new_item = {};
	    new_item.id = generateId();
	    new_item.descr = itemstr;
	    listd.lists[i].items.push(new_item);
	    generateListTables(listd.lists[i].id);
	    $('#_newList').focus();
	    save();
	}
    }

    
}

function deleteItemFromList(list, itemId) {
    var new_items = [];
    for (i in list.items) {
	if (list.items[i].id != itemId) {
	    new_items.push(list.items[i]);
	}
    }
    list.items = new_items;
    generateListTables();
}


function deleteItem(itemId) {
    for (i in listd.lists) {
	deleteItemFromList(listd.lists[i], itemId);
    }
    generateListTables();
    save();
}

function generateListTable(list, listId) {
    var tableStr = '';
    tableStr += '<div class=\"lista\">';
    tableStr += '  <table>';
    tableStr += '     <tr class=\"first_row\"><td>' + list.name + '<img class=\"list_delete\" list_id=\"' + list.id + '\" src=\"images/delete.png\" title=\"delete list\" alt=\"delete list\"/></td></tr>';

    for (i in list.items) {
	tableStr += '<tr><td>' + list.items[i].descr + '<img class=\"item_delete\" id=\"' + list.items[i].id + '\" src=\"images/delete.png\" title=\"delete list\" alt=\"delete list\"/></td></tr>';
    }

    newListId = '';
    if (listId == list.id) {
	newListId = "_newList";
    }
	
    tableStr += '<tr><td><input class=\"input_item\" type=\"text\" id=\"' + newListId + '\" name=\"lista\"/><img class=\"item_add\" id=\"' + list.id + '\" src=\"images/add.png\" title=\"add item\" alt=\"add item\"/></td></tr>';
    tableStr += '</table></div>';

    return tableStr;
}

function generateListTables(listId) {
    $('#lists').html('');

    for (i in listd.lists) {
	$('#lists').append(generateListTable(listd.lists[i], listId));
    }

    $(".list_delete").click(function(event){
	    deleteList($(this).attr('list_id'));
	});

    $('.list_delete').hover(function() {
	    $(this).addClass('pretty-hover');
	}, function() {
	    $(this).removeClass('pretty-hover');
	});

    $(".item_delete").click(function(event){
	    deleteItem($(this).attr('id'));
	});

    $('.item_delete').hover(function() {
	    $(this).addClass('pretty-hover');
	}, function() {
	    $(this).removeClass('pretty-hover');
	});


    $(".item_add").click(function(event){
	    addItem($(this).attr('id'), $(this).siblings(':first').val());
	});

    $(".input_item").bind('keypress', function(e) {
	    if(e.keyCode==13){
		addItem($(this).siblings(':first').attr('id'), $(this).val());
	    }
	});


    $('.item_add').hover(function() {
	    $(this).addClass('pretty-hover');
	}, function() {
	    $(this).removeClass('pretty-hover');
	});
}

function addList() {
    new_list = {};
    new_list.name = $("#new_list").val();
    new_list.id = generateId();
    new_list.items = [];
    listd.lists.push(new_list);
    $("#new_list").val("");
    generateListTables();
    save();
}




$(document).ready(function(){

	$("#addlist").click(function(event){
		addList();
	    });
	
	
	$("#new_list").bind('keypress', function(e) {
		if(e.keyCode==13){
		    addList();
		}
	    });

	$('#addlist').hover(function() {
                $(this).addClass('pretty-hover');
            }, function() {
                $(this).removeClass('pretty-hover');
            });

	generateListTables();
    });

