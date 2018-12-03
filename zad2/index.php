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
                <button class="btn btn-primary" @click="randomNums()">Losuj liczby</button> <br>
                rand1: {{ randNum1 }}  rand2:{{randNum2}}
            </div>
            <div class="col-sm-12">
                <br>
                euler: {{euler}}
                <br>
                moduł (N): {{modul}}
                <br>
                nasze E to: {{valE}}
                <br>
                nasze D to {{valD}}
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-12">
                <div>
                    <button class="btn btn-primary" @click="saveKey(valE, modul, 'public')" :disabled="finish == false">Zapisz Klucz Prywatny</button>
                    <button class="btn btn-primary" @click="saveKey(valD, modul, 'private')" :disabled="finish == false">Zapisz Klucz Publiczny</button>

                    <div class="alert alert-success mt-5" role="alert" v-if="statusFile" >
                       Plik zapisany
                    </div>
                </div>
            </div>
        </div>
    </div>



<!--    <a  @click="post1()">adsasd</a>-->
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="../node_modules/vue/dist/vue.js"></script>
<script src="../node_modules/axios/dist/axios.min.js"></script>

<script>
    new Vue({
        el: '#app',
        data: {
            randNum1: 0,
            randNum2: 0,
            euler: 0,
            modul: 0,
            valE: 0,
            valD: 0,
            finish: false,
            statusFile: false,
        },

        methods:{


            randomNums: function () {
                let tempThis = this;
                axios.post('fet2.php', {
                })
                    .then(function (response) {
                        // console.log(response.data);
                        tempThis.randNum1 =  response.data.num1;
                        tempThis.randNum2 = response.data.num2;
                        tempThis.euler = response.data.euler;
                        tempThis.modul = response.data.modul;
                        tempThis.valE = response.data.valE;
                        tempThis.valD = response.data.valD;
                        tempThis.finish = true;
                    })
                    .catch(function (error) {
                        console.log(error.response);
                    });

            },

            saveKey: function (a, b, c) {
                let tempThis = this;
                axios.post('fet2-1.php', {
                        type: c,
                        valFirst: a,
                        valMod: b,
                })
                    .then(function (response) {
                        // console.log(response.data);
                        tempThis.statusFile = response.data;

                    })
                    .catch(function (error) {
                        console.log(error.response);
                    });

            }
        },

        watch:{
            statusFile: function () {
                let tempThis = this;
                setTimeout(function () {
                    tempThis.statusFile = false;
                }, 1000)

            }
        }
    })
</script>
</body>
</html>