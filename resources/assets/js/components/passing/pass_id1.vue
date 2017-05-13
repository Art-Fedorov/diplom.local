<template>
  <div class="container-lg">
    <div class="container-md">
      <pass-timer :test="tests" :timer="timer"></pass-timer>
      <div class="pass-container row">
        <div class="pass-main col-lg-6 col-md-7 col-sm-7 col-xs-12">
          <h2 class="pass__header text-left ">{{tests.name}}</h2>
          <h3 class="pass__questions">
            <div class="pass__question-number">{{currentQuestionNumber+1<10?'0'+(currentQuestionNumber+1):(currentQuestionNumber+1)}}.</div>
            <div class="pass__question-content ql-container" v-html="currentQuestion.question"></div>
          </h3>
          <div v-if="currentQuestion.word==0">
            <h4 class="pass__header pass__header--sm">Варианты ответов: <span v-if="tests.view_more_1_answer&&moreThanOneTrueAnswer(currentQuestion)">(несколько)</span></h4>
            <form id="pass-question-form" action="" @submit.prevent="setAnswers()">
              <div v-if="tests.view_more_1_answer">
                <div v-if="moreThanOneTrueAnswer(currentQuestion)">
                  <div class="checkbox-container pass-answer-item" v-for="(answer,index) in currentQuestion.answers">
                    <input type="checkbox" :checked="tests.questions[currentQuestionNumber].answers[index].checked==true" value="None" :answer-id="answer.id" :id="'answer'+index" name="check" />
                    <label :for="'answer'+index" class="label-text">{{answer.answer}}</label>
                    <label :for="'answer'+index" class="label-style"></label>
                  </div>
                  <button type="submit" class="btn  btn-success">
                    Ответить
                  </button>    
                  <a class="btn-alternative" @click="incCurrentQuestionNumber">Пропустить</a>
                </div>
                <div v-else>
                  <div class="radio-container pass-answer-item" v-for="(answer,index) in currentQuestion.answers">
                    <input type="radio" :checked="tests.questions[currentQuestionNumber].answers[index].checked==true" :answer-id="answer.id" :id="'answer'+index" name="check" />   
                    <label :for="'answer'+index" class="label-text">{{answer.answer}}</label>
                    <label :for="'answer'+index" class="label-style"></label>
                  </div>
                  <button type="submit" class="btn  btn-success">
                    Ответить
                  </button>    
                  <a class="btn-alternative" @click="incCurrentQuestionNumber">Пропустить</a>
                </div>
              </div>
              <div v-else>
                <div class="checkbox-container pass-answer-item" v-for="(answer,index) in currentQuestion.answers">
                  <input type="checkbox" :checked="tests.questions[currentQuestionNumber].answers[index].checked==true" value="None" :answer-id="answer.id" :id="'answer'+index" name="check" />
                  <label :for="'answer'+index" class="label-text">{{answer.answer}}</label>
                  <label :for="'answer'+index" class="label-style"></label>
                </div>
                <button type="submit" class="btn  btn-success">
                  Ответить
                </button>    
                <a class="btn-alternative" @click="incCurrentQuestionNumber">Пропустить</a>
              </div>          
            </form>
          </div>
          <div v-else>
            <h4 class="pass__header pass__header--sm">Введите слово/число</h4>
            <form id="pass-question-form" action="" @submit.prevent="setAnswers()">
              <div class="form-group">
                <input type="hidden" name="id_answer" :value="currentQuestion.answers[0].id">
                <input class="form-control" type="text" name="answer">
              </div>
              <button type="submit" class="btn  btn-success">
                Ответить
              </button>    
              <a class="btn-alternative" @click="incCurrentQuestionNumber">Пропустить</a>
            </form>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12" >
          <a href="" class="" @click.prevent="passed=true" title="У вас остались вопросы без ответа!">✖ Закончить тест</a>
          <div class="pass-other" v-if="tests.pass_other_questions">
            <div class="pass-other__header">
              <div class="q_mark" title="Вы можете пропускать вопросы и возвращаться к ним позже"></div>
              Перемещение по вопросам
            </div>
            <div class="pass-other__questions" v-if="tests.pass_other_questions">

              <span class="pass-other__item" :class="{passed: question.passed&&question.index!=currentQuestionNumber,active: question.index==currentQuestionNumber}" v-for="question in tests.questions" @click="setCurrentQuestion(question.index)">
                  {{(question.index+1)<10?'0'+(question.index+1):(question.index+1)}}
              </span>

            </div>
            
          </div>
        </div>
      </div>
    </div>
    <div class="hidden">{{b}}</div>
    <!-- <div v-show="passed">{{questionsAnswers}}</div> -->
    <!-- <pass-result v-if="passed"></pass-result> -->
  </div>
</template>
<script type="text/javascript">
import passTimer from './pass_timer.vue';
export default({
  components: {
    'pass-timer': passTimer
  },



  props: ['test','timer','qa','idResult'],



  data: function(){
    return{
      tests: JSON.parse(this.test),
      currentQuestionNumber: 0,
      passedCount: 0,
      passed: false,
      time: '',
      questionsAnswers: [],
      //костыль
      b: 0
    };
  },


  created(){
   
    let self=this;
    if (this.qa){
      let qa=JSON.parse(this.qa);
      for (let k in qa){
        let item={
          id_answer: qa[k]['id_answer'],
          id_question: qa[k]['id_question'],
          id_test: qa[k]['id_test'],
          id_user: qa[k]['id_user']
        }
        self.questionsAnswers.push(qa[k]);
        self.passedCount=qa.length;
      }
    }
    self.modifyQuestions();
    
    //console.log(this.tests.questions,this.questionsAnswers);
    if (self.tests.questions.length>0){
      if (self.tests.questions[0].passed){
        self.incPassed();
      }
    }
  },


  beforeMount() {
  },


  mounted(){
  },
  computed:{
    currentQuestion(){
      return this.tests.questions[this.currentQuestionNumber];
    },
    questionsCount(){
      return Object.keys(this.tests.questions).length;
    }
  },


  methods:{
    

    modifyQuestions(){
      //перемешиваем вопросы
      if (this.tests.shuffle_questions){
        this.tests.questions=shuffle(this.tests.questions);
      }
      for (var key in this.tests.questions){
        //ставим индексы вопросам
        this.tests.questions[key].index=parseInt(key);
        //свойство для отслеживания вопросов, на которые даны ответы
        this.tests.questions[key].passed=false;
        //Проверка на то, существуют ли уже отвеченные вопросы после перезагрузки страницы
        for (var k in this.questionsAnswers){
          if (this.questionsAnswers[k].id_question==this.tests.questions[key].id){
            this.tests.questions[key].passed=true;
          }
        }
        let q = this.tests.questions[key];
        //Перемешивание ответов
        if (this.tests.shuffle_answers){
          q.answers=shuffle(q.answers);
        }
        var answs=this.tests.questions[key].answers;
        //Проход по вариантам ответов для текущего вопроса
        //и добавление свойства для отслеживания отмеченности варианта ответа
        for (var k in answs){
          answs[k].checked=false;
        }      
      }
      this.b++;
    },
    //Для стандартных тестов
    
    setAnswers(){
      var self=this;
      var idUser=self.$parent.$data.idUser;
      var idTest=self.tests.id;
      var idQuestion=self.currentQuestion.id;
      self.tests.questions[self.currentQuestionNumber].passed=true;
      let data={};
      if($('#pass-question-form .pass-answer-item input:checked').length>0){
        for (var k in self.tests.questions[self.currentQuestionNumber].answers){
          self.tests.questions[self.currentQuestionNumber].answers[k].checked=false;
        }
        
        $('#pass-question-form .pass-answer-item input').each(function(key,val){


          if ($(this).prop('checked')){
            self.tests.questions[self.currentQuestionNumber].answers[key].checked=true;
            let answer=$(val).attr('answer-id');
            //data.answers.push({'id_answer':answer}); 
            data={
              id_user: idUser,
              id_test: idTest,
              id_question: idQuestion,
              id_answer: answer            
            };
            self.$http.post('/api/usertestqa',data)
              .then(function(response){  
                },function(error){
                  console.log(error.data);
                });
          }
          
        });
        self.questionsAnswers.push(data);
        self.passedCount++;
        self.incCurrentQuestionNumber();         
      } else 
      //число/ответ
      if ($('#pass-question-form [name="answer"]').length>0){
        data={
          id_user: idUser,
          id_test: idTest,
          id_question: idQuestion,
          id_answer: parseInt($('#pass-question-form [name="id_answer"]').val()),
          answer: $('#pass-question-form [name="answer"]').val()
        };
        //console.log(data);
        self.$http.post('/api/usertestqa',data)
        .then(function(response){   
          
          },function(error){
            console.log(error.data);
          });
        //self.questions[self.currentQuestionNumber].answers[0].checked=true;
        self.questionsAnswers.push(data);
        self.passedCount++;
        self.incCurrentQuestionNumber();    
      }



      
      //this.intermediateData();
    },
    setCurrentQuestion(idx){
      if (!this.tests.questions[idx].passed)
        this.currentQuestionNumber=idx;
    },
    //метод для добавления класса, в случае, если ответ на вопрос уже дан
    checkPassed(index){
      for (var key in this.tests.questions[index].answers){
        if (this.tests.questions[index].answers[key].checked){
          this.tests.questions[index].passed=true;
          return true;
        }
      }
      return false;
    },
    incCurrentQuestionNumber(){
      var self=this;
      self.b++;
      if(self.passedCount==self.tests.questions.length){
        self.passed=true;
        
      } else {
        this.$nextTick(function(){
          $('#pass-question-form .pass-answer-item input:checked').prop('checked',false);
        })
        
        self.incPassed();
      }
    },
    //Метод для пропуска уже отвеченных вопросов
    incPassed(){
      var self=this;
      do {
          if (self.currentQuestionNumber+1!=self.questionsCount){
            self.currentQuestionNumber++;
          } else {
            self.currentQuestionNumber=0;
          }
        } while(self.tests.questions[self.currentQuestionNumber].passed)
    },
    //Для настройки "показывать если правильных вариантов ответов больше одного"
    moreThanOneTrueAnswer(question){
      let k=0;
      for (var key in question.answers){
        if (question.answers[key].iscorrect){
          k++;
        }
      }
      return k>1?true:false;
    },

    intermediateData(){
      let data=this.formData();
      this.$http.post('/api/usertestqa', data).then(function(response) {

        }, function(response) {
            $('.error').append($.parseHTML(response.body));
              console.log(response.body);
          });
    },
    onPassed(){
      var red = '/pass/test/'+this.tests.id+'/result';
      let data=this.formData();

      redirect(red, {'idResult': this.idResult,'data': data , _token: $('[name="csrf-token"]').attr('content')},'POST');
    },
    formData(){
      var data = {
        data: this.questionsAnswers,
        id_test: this.tests.id,
        id_user: this.tests.id_user,
        id_alg: this.tests.id_alg
      };
      data=JSON.stringify(data);
      return data;
    },
  },



  watch:{
    b(val){
      this.b=val==1000?0:val;
    },
    passed(val){
      if (val) {
        this.onPassed();
      }
    },
    questionsAnswers(val){
      //console.log(val);

    }
  }
});
function redirect(location, args, method)
{
    var form = '';
    $.each( args, function( key, value ) {
        //value = value.split('"').join('\"')
        form += '<input type="hidden" name=\''+key+'\' value=\''+value+'\'>';
    });
    $('<form action="' + location + '" method="'+method+'">' + form + '</form>').appendTo($(document.body)).submit(); 

}
function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}
</script>