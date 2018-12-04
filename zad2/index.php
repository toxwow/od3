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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">


</head>
<body>
<div id="app" v-cloak>
    <div class="container" style="margin-top:50px;">
        <div class="row">
            <div class="col-sm-12 mb-5">
                <div class="card">
                    <div class="card-body">
                        Wylosuj dwie liczby pierwsze z zakresu <b>100 - 100 000</b> w celu wygenerowania klucza publicznego i prywatnego
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <button class="btn btn-primary w-100" @click="randomNums()">Losuj liczby</button> <br>
<!--                rand1: {{ randNum1 }}  rand2:{{randNum2}}-->
            </div>
<!--            <div class="col-sm-12">-->
<!--                <br>-->
<!--                -->
<!--                <br>-->
<!--                -->
<!--                <br>-->
<!--                nasze E to: {{valE}}-->
<!--                <br>-->
<!--                nasze D to {{valD}}-->
<!--            </div>-->

                <div class="col-sm-6 my-5">
                    <div class="card">
                        <div class="card-body" style="position: relative">
                            <h5 class="card-title">Klucz Prywatny</h5>
                            <div v-if="modul != 0">
                                <div style="position:absolute; right: 20px; top: 10px;" data-toggle="modal" data-target="#exampleModal">
                                    <i style="cursor: pointer;" class="fas fa-info-circle"></i>
                                </div>
                                <p>({{valD}}:{{modul}})</p>
                            </div>
                            <button class="btn btn-secondary" @click="saveKey(valD, modul, 'private')" :disabled="finish == false">Zapisz Klucz Prywatny</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 my-5">
                    <div class="card">
                        <div class="card-body" style="position: relative">
                            <h5 class="card-title">Klucz Publiczny</h5>
                            <div  v-if="modul != 0">
                                <div style="position:absolute; right: 20px; top: 10px;" data-toggle="modal" data-target="#exampleModal">
                                    <i style="cursor: pointer;" class="fas fa-info-circle"></i>
                                </div>
                                <p>({{valE}}:{{modul}})</p>
                            </div>
                            <button class="btn btn-secondary" @click="saveKey(valE, modul, 'public')" :disabled="finish == false">Zapisz Klucz Publiczny</button>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div>
                    <div class="alert alert-success" role="alert" v-if="statusFile" >
                       Plik zapisany
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" v-show="codeFinish">
        <div class="row">
            <div class="col-12">
                <a href="../zad3/"><button class="btn btn-success w-100">Zakoduj tekst</button></a>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Wyliczone wartości</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul>
                        <li> 1 Wylosowana liczba pierwsza: <b>{{ randNum1 }}</b></li>
                        <li> 2 Wylosowna liczba pierwsza: <b>{{randNum2}}</b></li>
                    </ul>
                   <hr>
                    <ul>
                        <li>Euler: <b>{{euler}}</b></li>
                        <li>Moduł(N): <b>{{modul}}</b></li>
                        <li>E: <b>{{valE}}</b></li>
                        <li>D: <b>{{valD}}</b></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

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
            codeFinish: false,
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
                        tempThis.codeFinish = response.data;

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
                }, 2500)

            }
        }
    })
</script>
</body>
</html>