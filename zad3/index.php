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
    <div class="" style="position: absolute; top: 20px; right: 20px;">
        <div>
            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" >Zobacz klucz</button>
        </div>
        <div class="mt-2">
            <a href="../zad2"> <button type="button" class="btn btn-outline-secondary w-100">Zmień klucz</button></a>
        </div>

    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="form-group mt-4">
                    <label for="exampleFormControlTextarea1">Wprowadź tekst</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="text"></textarea>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary w-100" :disabled="!textChangedStatus" @click="textUpdate">Zaktualizuj tekst</button>
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
                <button class="btn btn-success w-100 mt-3" @click="decodeText" :disabled="codeTextVal == ''" >Odkoduj Tekst</button>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-6" v-show="codeStatus">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Twój zakodowany tekst</h5>
                        <p class="card-text" style="text-wrap: normal">{{codeTextVal}}</p>

                    </div>
                </div>
            </div>
            <div class="col-sm-6" v-show="deCodeStatus">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Twój odkodowany tekst</h5>
                        <p class="card-text">{{decodeTextVal}}</p>
                    </div>
                </div>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Twoje klucze</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <b>klucz prywatny</b>: {{privateKeyVal}}
                    </div>

                    <div>
                        <b>klucz publiczny</b>: {{publicKeyVal}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
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
            text: "",
            textChangedStatus: false,
            changeText: false,
            codeTextVal: "",
            decodeTextVal: "",
            codeStatus: false,
            deCodeStatus: false,
            privateKeyVal: '',
            publicKeyVal: '',
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
                        tempThis.deCodeStatus = true;

                    })
                    .catch(function (error) {
                        console.log(error.response);
                    });
            },

            textUpdate: function(){
                tempThis =this;
                this.deCodeStatus = false;
                this.codeStatus = false;
                this.codeTextVal = '';
                this.decodeTextVal = '';
                tempThis.textChangedStatus = false;
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
            },

            text: {
                handler: function(val, oldVal) {
                    // console.log(oldVal);
                    if(oldVal === "" || oldVal === undefined ){

                    }

                    else{
                        this.textChangedStatus = true;
                    }

                },
                immediate: true
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
            axios.get('../key/public.key', {

            })
                .then(function (response) {
                    publicKeyValTemp = response.data;
                    tempThis.publicKeyVal = publicKeyValTemp.replace("\n", " : ");

                })
                .catch(function (error) {
                    console.log(error.response);
                });

            axios.get('../key/private.key', {

            })
                .then(function (response) {
                    privateKeyValTemp = response.data;
                    tempThis.privateKeyVal = privateKeyValTemp.replace("\n", " : ");

                })
                .catch(function (error) {
                    console.log(error.response);
                });
        },




    })
</script>
</body>
</html>