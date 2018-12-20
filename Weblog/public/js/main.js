(function($){

	$("#search").click(function() {
		var input = $("#searchbillet").val();
		var baseurl = $("#baseurl").val();
		document.location.href=baseurl+input;
	});

	$(".edit").click(function(e){
		e.preventDefault();
		var $comment = $(this).parents('.comment');
		var $form = $('#comment');
		var id = $(this).data('id');
		var post = $comment.data('post');

		$.ajax({
			// envois une requete de type post
			type: "POST",
			// sur la page login.php
			url: "#",

			// avec comme donnée
			data: "action=select-edit&id_comment="+post,
			success: function(html){
				if(html!='false')    {
					// la connexion a réussi, on est redirigé
					console.log("okey");
					$form.find('textarea').html(html);
					$form.find('#action').val('edit');

					$form.hide();
					$comment.after($form);
					$form.slideDown();
					$('#parent_id').val(id);
					$('#id_comment').val(post);
				}
				else {
					alert("Un problème est survenu!");
				}
			}
		});
	});

	$(".reply").click(function(e){
		e.preventDefault();
		var $comment = $(this).parents('.comment');
		console.log($comment);
		var $form = $('#comment');
		var id = $(this).data('id');

		$form.find('#action').val('comment');
		$form.hide();
		$comment.after($form);
		$form.slideDown();
		$('#parent_id').val(id);
		$('#id_comment').val(0);
		$('#editor').html("");
	});

	$(".delete").click(function(e){
		e.preventDefault();

		var $comment = $(this).parents('.comment');
		var id = $(this).data('id');
		var post = $comment.data('post');
		$.ajax({
			// envois une requete de type post
			type: "POST",
			// sur la page login.php
			url: "#",

			// avec comme donnée
			data: "action=delete&parent_id="+id+"&id_comment="+post,
			success: function(html){
				if(html=='true')    {
					// la connexion a réussi, on est redirigé
					console.log("okey");
					$comment.parent().fadeOut();
				}
				else {
					alert("Un problème est survenu!");
				}
			}
		});
	});

	$(".deletecontact").click(function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var $message = $(this).parents('.message');
		$.ajax({
			// envois une requete de type post
			type: "POST",
			// sur la page login.php
			url: "#",

			// avec comme donnée
			data: "action=delete&id_contact="+id,
			success: function(html){
				if(html=='true')    {
					$message.next().slideUp(0);
					$message.fadeOut(1000);
				}
				else {
					alert("Un problème est survenu!");

				}
			}
		});

	});


    $.fn.bbcode = function(options){
        $("#bbcode_bb_bar a img").css("border", "none");
        var id = '#' + $(this).attr("id");
        var e = $(id).get(0);

        $('#bbcode_bb_bar button').click(function() {
            var button_id = $(this).attr("id");
            var start = '['+button_id+']';
            var end = '[/'+button_id+']';

            var param="";
            if (button_id=='img')
            {
                param=prompt("Enter image URL","http://");
                largeur=prompt("Enter la largeur","50px");
                hauteur=prompt("Enter la hauteur","50px");
                if (param)
                    start = '[img=' + largeur + '.' + hauteur + ']'+param;
            }
            else if (button_id=='url')
            {
                param=prompt("Enter URL","http://");
                if (param)
                    start = '[url=' + param + ']'+param;
            }
            else if (button_id=='br')
            {
                start = '[br]';
                end = '';
            }
            insert(start, end, e);
            return false;
        });
    };

    insert = function(start, end, element) {
        if (document.selection) {
            element.focus();
            sel = document.selection.createRange();
            sel.text = start + sel.text + end;
        } else if (element.selectionStart || element.selectionStart == '0') {
            element.focus();
            var startPos = element.selectionStart;
            var endPos = element.selectionEnd;
            element.value = element.value.substring(0, startPos) + start + element.value.substring(startPos, endPos) + end + element.value.substring(endPos, element.value.length);
        } else {
            element.value += start + end;
        }
    };

   $("#editor").bbcode();


   // administration:
   $("#addpostform").click(function(e)
   {
   		e.preventDefault();
   		$('#addpost').slideDown();

   		$('#addpost').find('#action').val('add');
		$('#addpost').find('#id_billet').val(0);
		$('#formadmin').attr("action", $base_url+"admin/add_articles");

		$('#addpost').find('#title').val("");
		$('#addpost').find('#inlineCheckbox1').attr('checked', false);
		$('#addpost').find('#inlineCheckbox2').attr('checked', false);
		$('#addpost').find('#inlineCheckbox3').attr('checked', false);
		$('#addpost').find('#inlineCheckbox4').attr('checked', false);
		$('#addpost').find('#inlineCheckbox5').attr('checked', false);
		$('#addpost').find('#inlineCheckbox6').attr('checked', false);
		$('#addpost').find('#image').val("");
		$('#addpost').find('#editor').val("");

   });

   	$(".deletebillet").click(function(e){
		e.preventDefault();

		var $billet = $(this).parents('.billet');
		var id = $(this).data('id');
		$.ajax({
			// envois une requete de type post
			type: "POST",
			// sur la page login.php
			url: $base_url+"admin/delete_articles",

			// avec comme donnée
			data: "action=delete&id_billet="+id,
			success: function(html){
				if(html=='true')
				{
					// la connexion a réussi, on est redirigé
					console.log("okey");
					$billet.fadeOut();
				}
				else {
					alert("Un problème est survenu!");

				}
			}
		});
	});

   	$(".editbillet").click(function(e)
   {
   		e.preventDefault();
   		var id = $(this).data('id');
   		//document.location.href=$base_url+"admin/edit_articles/"+id

		$.ajax({
			// envois une requete de type post
			type: "POST",
			// sur la page login.php
			url: $base_url+"admin/articles/",

			// avec comme donnée
			data: "action=edit&id_billet="+id,
			success: function(html){
				if(html!='false')    {
					// la connexion a réussi, on est redirigé
					$('#addpost').slideDown();

					$('#addpost').find('#action').val('edit');
					$('#addpost').find('#id_billet').val(id);
					$('#formadmin').attr("action", $base_url+"admin/update_articles");

					var obj = jQuery.parseJSON( html );
					$('#addpost').find('#title').val(obj.title);
					$('#addpost').find('#inlineCheckbox1').attr('checked', (obj.categorie.search("art") < 0)? false : true);
					$('#addpost').find('#inlineCheckbox2').attr('checked', (obj.categorie.search("voyages") < 0)? false : true);
					$('#addpost').find('#inlineCheckbox3').attr('checked', (obj.categorie.search("animaux") < 0)? false : true);
					$('#addpost').find('#inlineCheckbox4').attr('checked', (obj.categorie.search("nature") < 0)? false : true);
					$('#addpost').find('#inlineCheckbox5').attr('checked', (obj.categorie.search("nourriture") < 0)? false : true);
					$('#addpost').find('#inlineCheckbox6').attr('checked', (obj.categorie.search("dev") < 0)? false : true);
					$('#addpost').find('#image').val(obj.image);
					$('#addpost').find('#editor').val(obj.content);
				}
				else {
					alert("Un problème est survenu!");
				}
			}
		});
   });


 	// User:
   $("#adduserbutton").click(function(e)
   {
   		e.preventDefault();
   		$('#adduser').slideDown();

   		$('#adduser').find('#action').val('add');
		$('#adduser').find('#id_billet').val(0);
		$('#formadmin').attr("action", $base_url+"admin/add_articles");

		$('#adduser').find('#nom').val("");
		$('#adduser').find('#prenom').val("");
		$('#adduser').find('#email').val("");
		$('#adduser').find('#password').val("");
		$('#adduser').find('#level').val("0");

		$('#adduser').find('#editor').val("");

   });

   	$(".deletemembre").click(function(e){
		e.preventDefault();
		var $user = $(this).parents('.user');
		var id = $(this).data('id');
		var level = $(this).data('level');

		$.ajax({
			// envois une requete de type post
			type: "POST",
			// sur la page login.php
			url: $base_url+"admin/delete_user",

			// avec comme donnée
			data: "action=delete&admin="+level+"&id_user="+id,
			success: function(html){
				if(html=='true')
				{
					// la connexion a réussi, on est redirigé
					console.log("okey");
					$user.fadeOut();
				}
				else {
					alert("Un problème est survenu!");

				}
			}
		});
	});

	$(".editmembre").click(function(e)
	{
		e.preventDefault();

		var id = $(this).data('id');
		var level = $(this).data('level');

		$.ajax({
			// envois une requete de type post
			type: "POST",
			// sur la page login.php
			url: $base_url+"admin/user/",

			// avec comme donnée
			data: "action=edit&id_user="+id,
			success: function(html){
				if(html!='false')    {
					// la connexion a réussi, on est redirigé
					$('#adduser').slideDown();

					$('#adduser').find('#action').val('edit');
					$('#adduser').find('#id_user').val(id);
					$('#adduser').attr("action", $base_url+"admin/update_user");

					var obj = jQuery.parseJSON( html );
					$('#adduser').find('#nom').val(obj.nom);
					$('#adduser').find('#prenom').val(obj.prenom);
					$('#adduser').find('#email').val(obj.email);
					$('#adduser').find('#username').val(obj.username);
					$('#adduser').find('#password').val("");
					$('#adduser').find('#password2').val(obj.password);
					$('#adduser').find('#level').val(obj.admin);
				}
				else {
					alert("Un problème est survenu!");
				}
			}
		});
	});

})(jQuery)