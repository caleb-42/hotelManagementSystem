app.filter('nairacurrency', function(){
    return function(input){
        if(input){
            return "N " + input;
        }
    }
});