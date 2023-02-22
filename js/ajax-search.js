var select2 = $("#headerSearch").select2({
    allowClear: true,
    multiple: true,
    ajax: {
        url: "https://app.fablefrog.com/api/search.php",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                qq: params.term, // search term
                page: params.page
            };
        },
        processResults: function (data, params) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;

            return {
                results: data.items,
                pagination: {
                    more: (params.page * 30) < data.total_count
                }
            };
        },
        cache: true
    },
    placeholder: 'Search for Fables or Fable-Makers(Users) Here',
    minimumInputLength: 3,
    templateResult: formatRepo,
    formatSelection: formatRepoSelection,
    escapeMarkup: function(m) { return m; }
}).data('select2');


function formatRepo (repo) {
    if (repo.loading) {
        return repo.text;
    }
    if(repo.type === "user"){
        var $container = $( "<div class=\"commonLink mt-2 full-width\"> <div class=\"imageContents \"> <img style='border-radius: 50%; width: 50px; height: 50px; object-fit: cover;' src=\""+repo.avatar+"\"><div style=\"width: 75%;padding-top: 10px;padding-left: 10px;\">"+repo.username+"</div><button style=\"height: 35px; float: right\" class=\"btn btn-primary info\" data-url='https://app.fablefrog.com/profile/"+repo.id+"' >View Profile</button></div></div>");
    }else{
        var $container = $("<div class=\"borderBoxBody info\" data-url='https://app.fablefrog.com/profile/\"+repo.id+\"' style=\"padding: 0; min-height: 25vh; background-position: center;background-size: cover;border-radius: 1em; margin:0; background-image: url('"+repo.cover+"');\"><div style=\"width: 100%; height: 100%; min-height: 25vh; padding: 1em; background: #00000070; border-radius: 1em; display: flex;\"><div class=\"col-12\"><h1 class=\"mainHeading GtSuper whiteText\" style=\" margin-top: 10px;font-size: 1.9rem\">"+repo.postBody+"</h1><div class=\"whiteText mt-2 mb-2\">Posted: "+repo.time+"</div><div class=\"whiteText mt-2 mb-2\" style=\"text-decoration: none\"><span>Told By: <img style=\"object-fit: cover; border-radius: 50%; width: 30px; height: 30px;\" src=\""+repo.avatar+"\"></span> <p class=\"ml-3\" style=\" display:inline\">"+repo.username+"</p></div></div></div></div>");
    }
    return $container;
}

function formatRepoSelection (repo) {
    return repo.full_name || repo.text;
}
/*

select2.onSelect = (function(fn) {
    console.log("Clicked");
    return function(data, options) {
        var target;
        console.log("Clicked cp 2");

        if (options != null) {
            target = $(options.target);
        }

        if (target && target.hasClass('info')) {
            console.log("Clicked cp 3");
            alert('click!');
        } else {
            console.log("Clicked cp 4");
            return fn.apply(this, arguments);
        }
    }
})(select2.onSelect);
*/

$('#headerSearch').on('select2:select', function (e) {
    console.log(e.params.data.type);
   if(e.params.data.type === "user"){
       window.location = "https://app.fablefrog.com/profile/"+e.params.data.username;
   }else{
       window.location = "https://app.fablefrog.com/index.php?id="+e.params.data.id;
   }

});