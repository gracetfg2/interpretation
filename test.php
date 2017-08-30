<html>
<script>
var get_params = {}; // prefer literal over Object constructors.

var params = {'name':'john', 'age':'23'}; // @runtime (as object literal)

for (var key in params){
	
    if(params.hasOwnProperty(key)) { // so we dont copy native props
        get_params[key] = params[key];
        console.log(params[key]);
    }
}
</script>
</html>
