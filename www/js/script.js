
var home = "http://dev.ithinkisam.com/grubhubv2/web/";
var viewRecipe = "view/?recipe=";
var viewHub = "view/?hub=";
var viewUser = "view/?user=";

// $(document).on("click", "a", function(event) {
    // event.preventDefault();
    // location.href = $(event.target).closest("a").attr("href");
// });

$(document).ready( function() {
    
    $("a[href='#top']").click( function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });
    
    $("#search-toggle-link").click(function() {
        $(".search-form").toggleClass("active");
        $(".search-toggle").toggleClass("active");
        
        if ($(".search-form").hasClass("active")) {
            $("#q").focus();
        }
    });
    
    $("#q").keyup( function(event) {
        var searchString = $("#q").val();
        
        $.post(home + "q/",
            { q: searchString},
            function(data) {
                if (data != "") {
                    console.log(data);
                    var json = jQuery.parseJSON(data);
                    
                    $(".search-results").html("");
                    var recipeString = "<h4>Recipes</h4>";
                    recipeString += "<ul class='list-unstyled search-result'>";
                    if (json.recipes.length == 0) {
                        recipeString += "<li>(No results)</li>";
                    } else {
                        for (var index in json.recipes) {
                            console.log(json.recipes[index]);
                            var viewUrl = home + viewRecipe + json.recipes[index].recipeId;
                            var name = json.recipes[index].name;
                            recipeString += "<li><a href='" + viewUrl + "'>" + name + "</a></li>";
                        }
                    }
                    recipeString += "</ul>";
                    $(".search-results").append(recipeString);
                    
                    var hubString = "<h4>Hubs</h4>";
                    hubString += "<ul class='list-unstyled search-result'>";
                    if (json.hubs.length == 0) {
                        hubString += "<li>(No results)</li>";
                    } else {
                        for (var index in json.hubs) {
                            var viewUrl = home + viewHub + json.hubs[index];
                            var hubName = json.hubs[index];
                            hubString += "<li><a href='" + viewUrl + "'>" + hubName + "</a></li>";
                        }
                    }
                    hubString += "</ul>"
                    $(".search-results").append(hubString);
                    
                    var userString = "<h4>Users</h4>";
                    userString += "<ul class='list-unstyled search-result'>";
                    if (json.users.length == 0) {
                        userString += "<li>(No results)</li>";
                    } else {
                        for (var index in json.users) {
                            var viewUrl = home + viewUser + json.users[index].username;
                            var displayName = json.users[index].displayName;
                            userString += "<li><a href='" + viewUrl + "'>" + displayName + "</a></li>";
                        }
                    }
                    userString += "</ul>";
                    $(".search-results").append(userString);
                    
                    
                    // DEBUG INFO
                    console.log("User size: " + json.users.length);
                    console.log("Recipe size: " + json.recipes.length);
                    console.log("Hub size: " + json.hubs.length);
                }
            });
    });
    
});