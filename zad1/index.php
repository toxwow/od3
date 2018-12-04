<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <style>
        @import '../node_modules/bootstrap/dist/css/bootstrap.css';
        /*@import 'node_modules/bootstrap/js/dist/collapse.js';*/
        [v-cloak] > * { display:none }
        [v-cloak]::before { content: "loading…" }
    </style>

</head>
<body>
<div id="app" v-cloak>
    <div class="container" style="margin-top:50px;">
        <div class="row">
            <div class="col-sm-12">
                <input  class="form-control" type="number" min="5" v-model="number" placeholder="Wprowadź liczbę">
            </div>
            <div class="col-sm-12 mt-2">
                <div class="row">
                    <div class="col-6">
                        <select name="" class="form-control w-100" v-model="pow">
                            <option value="0" selected>Wybierz przedział</option>
                            <option :value="powValue" v-for="powValue in 9" :key="powValue"> 10 ^ {{powValue}}</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-info w-100" @click="randomNumber()">Losuj liczbę</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                <hr>
            </div>
            <div class="col-sm-6 my-5">
                <input type="number" class="form-control" min="1" :max="number" placeholder="Liczba prób" v-model="attempts">
            </div>
            <div class="col-sm-6 my-5">
                <button class="btn btn-secondary w-100" @click="post1">Przeprowadź test</button>
            </div>
        </div>
    </div>
    <div class="container"  v-show="test1 !=''">
        <div class="row">
            <div class="col-sm-12 mb-5">
                <hr>
            </div>
            <div class="col-12">
                <div class="alert d-flex justify-content-between align-items-center" role="alert" :class="{ 'alert-success': test1.test, 'alert-danger': !test1.test}">
                    <div v-if="test1.test">Liczba {{ test1.num }} jest liczbą (pseudo)pierwszą</div>
                    <div v-else>Liczba {{test1.num}} jest liczbą złożoną</div>
                    <div>
                        <a class="btn btn-light" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Zobacz wygenerowane liczby</a>
                    </div>

                </div>
            </div>

            <div class="col-12">
                <div class="collapse multi-collapse" id="multiCollapseExample1">
                    <div class="card card-body">
                        <ul>
                            <li v-for="el in test1.randomNumber">{{el}}</li>
                        </ul>
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
            test1: "",
            number: "5",
            pow: 0,
            attempts: "",
            drawMin: 2,
            drawMax: 0,
            numSplit1: 0,
            numSplit2: 0,
        },

        methods:{
            randomNumber: function() {
                let testOdd = Math.floor(Math.random()*Math.pow(10, this.pow));
                this.number = testOdd;
                if (testOdd % 2 === 0){
                    testOdd ++;
                }
                else{
                    return
                }
                this.number = testOdd;
            },

            post1: function () {
                let temp = this;
                axios.post('fet.php', {
                    number: temp.number,
                    attempts: temp.attempts,
                    drawMax: temp.drawMax,
                })
                    .then(function (response) {
                        console.log(response);
                        temp.test1 = response.data
                    })
                    .catch(function (error) {
                        console.log(error.response);
                    });

            }
        },
        watch:{
            number: function(){
                this.drawMax = this.number - 2

            },

            attempts: function(){
                if(this.attempts > this.number-4){
                    this.attempts = this.number-4
                }

            }
        }

    })
</script>
</body>
</html>