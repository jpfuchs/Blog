$(document).ready(function(){

	console.log("test");

	function getRaty()
	{

		
	$(".jpf").raty({
			path:"vue/images",
			readOnly: true,
			score: function() {
    			return $(this).attr('data-score');}
		});

	}
	
	$("#test").raty({
			path:"vue/images",
			scoreName: 'note'
		});
	

	$(".jpf").raty({
			path:"vue/images",
			readOnly: true,
			score: function() {
    			return $(this).attr('data-score');}
		});


	$("#test").children("input").val(0);


	$("#myButton").click(function(event)
	{
		
		event.preventDefault();

		var valide=true;
	
		//console.log("unclick");

		var nom = $("#myNom");

		if ( nom.val() == "" )
		{
			nom.addClass("warning");
			nom.next(".error").text("Attention rentrez un nom");

			valide=false;

		}
		else
		{
			nom.removeClass("warning");
			nom.next(".error").text("");

		}

		var comment= $("#comment");
		if ( comment.val() == "" )
		{
			comment.addClass("warning");
			comment.next(".error").text("Attention rentrez un commentaire");

			valide=false;

		}
		else
		{
			comment.removeClass("warning");
			comment.next(".error").text("");
		}


		if (valide == true)
		{
			$.ajax({
				type: "POST" ,
				//data:"prenom=jpf"
				data: $("#formComm").serialize(),
				dataType:"json"


			}).done (function(resultat)
			{
				$(".alert-success").remove();

				console.log(resultat);
				console.log(resultat.message);

				var message = "<p class='alert alert-success'>"+resultat.message+"</p>";
				$("#formComm").before(message);
				//$("#titi").text("votre commentaire a été bien ajouté");

				console.log(resultat.commentaire);
				$("#allComments").prepend(resultat.commentaire);

				getRaty();

				$("#testmess").text("");



			});

		}
		


	});

	$("#inputSearch").keyup(function(){

		//console.log($(this).val());

		$("#resultatRecherche").empty();

		var form = $(this).parent("form");
		$.ajax({
			type: "GET",
			url: form.attr("action"),
			data:form.serialize(),
			dataType:"json"
		}).done(function(resultat)
			{
				//console.log(resultat);
				console.log("jp");
				//console.log(resultat.listes);
				$("#resultatRecherche").append(resultat.listes);
			});

	});


 /*$(function() {
            $( "#datepicker" ).datepicker();
        });*/

     
       
  
   
});