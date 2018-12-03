<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <style>
        @import '../node_modules/bootstrap/dist/css/bootstrap.css';
        [v-cloak] > * { display:none }
        [v-cloak]::before { content: "loading…" }
    </style>

</head>
<body>
<div id="app" v-cloak>
    <div class="container" style="margin-top:50px;">
        <div class="row">
            <div class="col-sm-12">
                    <button @click="readFile"></button>
            </div>
        </div>
    </div>


</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="../node_modules/vue/dist/vue.js"></script>
<script src="../node_modules/axios/dist/axios.min.js"></script>

<script>
    new Vue({
        el: '#app',
        data: {

        },

        methods:{
            readFile: function () {
                axios.post('fet.php', {

                })
                    .then(function (response) {
                        console.log(response);
                        // tempThis.statusFile = response.data;

                    })
                    .catch(function (error) {
                        console.log(error.response);
                    });
            }

        },

        computed:{

        }


    })
</script>
</body>
</html>