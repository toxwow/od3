<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <style>
        @import '../node_modules/bootstrap/dist/css/bootstrap.css';
        [v-cloak] > * { display:none }
        [v-cloak]::before { content: "loading…" }

        .fade-enter-active, .fade-leave-active {
            transition: opacity .5s;
        }
        .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
            opacity: 0;
        }
    </style>

</head>
<body>
<div id="app" v-cloak>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="form-group mt-4">
                    <label for="exampleFormControlTextarea1">Wprowadź tekst</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="text"></textarea>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary w-100" @click="textUpdate">Zaktualizuj tekst</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container" >
        <div class="row">
            <div class="col-6">
                    <button class="btn btn-secondary w-100 mt-3" @click="codeText">Zakoduj Tekst</button>
            </div>
            <div class="col-6">
                <button class="btn btn-success w-100 mt-3" @click="decodeText">Odkoduj Tekst</button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <p>{{codeTextVal}}</p>
            </div>
            <div class="col-sm-6">
                <p>{{decodeTextVal}}</p>
            </div>
        </div>
    </div>
    <transition name="fade">
        <div class="container" style="position: absolute; top: 5px; left: 0; right: 0; margin: 0 auto;" v-show="changeText">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Zaktualizowano</strong> Twój tekst!
                    </div>
                </div>
            </div>
        </div>
    </transition>


</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="../node_modules/vue/dist/vue.js"></script>
<script src="../node_modules/axios/dist/axios.min.js"></script>

<script>
    new Vue({
        el: '#app',
        data: {
            text: "",
            changeText: false,
            codeTextVal: "",
            decodeTextVal: "",
            codeStatus: false,
            deCodeStatus: false,
        },

        methods:{


            codeText: function () {
                tempThis =this;
                axios.post('codeText.php', {

                })
                    .then(function (response) {
                        console.log(response);
                        tempThis.codeTextVal = response.data.codeText;
                        tempThis.codeStatus = true;


                    })
                    .catch(function (error) {
                        console.log(error.response);
                    });
            },

            decodeText: function () {
                tempThis =this;
                axios.post('decodeText.php', {

                })
                    .then(function (response) {
                        tempThis.decodeTextVal = response.data.decodeText;
                        tempThis.decodeStatus = true;

                    })
                    .catch(function (error) {
                        console.log(error.response);
                    });
            },

            textUpdate: function(){
                tempThis =this;
                axios.post('changeText.php', {
                    text: tempThis.text,
                })
                    .then(function (response) {
                        tempThis.changeText = response.data;

                    })
                    .catch(function (error) {
                        console.log(error.response);
                    });
            }


        },

        watch:{
            changeText: function () {
                tempThis =this;
                setTimeout(function () {
                    tempThis.changeText = false;
                }, 1500)

            }
        },

        mounted: function() {
            tempThis =this;
            axios.get('../textFiles/text.txt', {

            })
                .then(function (response) {
                    tempThis.text = response.data;

                })
                .catch(function (error) {
                    console.log(error.response);
                });
        },




    })
</script>
</body>
</html>