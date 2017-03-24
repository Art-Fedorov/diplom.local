<template>
  <div class="question-text-container">
    <pass-timer :test="tests" :timer="timer"></pass-timer>
    <h2 class="pass__header text-left ">{{tests.name}}</h2>
    <h3 class="pass__subheader text-left">Вопросы</h3>
    <div class="pass__questions">
      <div class="form-group form-group--question" :class="{active: question.active}" v-for="(question,i) in questions" @click.prevent="selectQuestion(question)">
        <a class="form-group__label question-text" v-html="question.question"></a>
        <div class="question-answers-container">
          <div class="question-answers" v-if="getAnswersByQuestionId(question.id).length>0">
            <a class="answer-label"  v-for="answer in getAnswersByQuestionId(question.id)" @click.prevent="extractAnswer(answer.id,i)">{{parseInt(answer.index)}}</a>          
          </div>
          <span class="question-answers" v-else>
            <span>ответов еще нет</span>
          </span>
<!--           <transition name="fast-fade"> -->
            <span v-show="question.active">
              <input type="text" class="form-control form-control--sm" v-model="question.inputText" v-on:keyup.enter="setInput(question)" title="Введите сюда номер вопроса">
              <button class="btn btn-primary btn-sm"  @click.prevent="setInput(question)" >ок</button>
            </span>
<!--           </transition> -->
          <transition name="fade">
            <span class="text-danger">
              {{question.errorMessage}}
            </span>
          </transition>
        </div>
      </div>
    </div>
    <h3 class="pass__subheader text-left">Ответы</h3>
    <div class="answer-text-container">
      
      <a href="#" v-for="(answer,index) in answers" class="answer-text" :class="{active: answer.active}" @click.prevent="answer.active?selectAnswer(answer,parseInt(index)+1):extractAnswer(answer.id,searchQuestionIdIndex(selectedQuestion))">
        <span class="answer-text__number">{{parseInt(index)+1}}.</span> 
        <span class="answer-text__content">{{answer.answer}}</span> 
      </a>
    </div>
    <div class="text-center"><button class="btn btn-success end-test" @click.prevent="getResults()">Завершить прохождение теста</button></div>
    <div class="hidden">{{b}}</div>
  </div>
</template>
<script>
  import passTimer from './pass_timer.vue';
  export default({
    components: {
      'pass-timer': passTimer
    },
    props: ['test','ques','answ','timer'],
    data(){
      return{
        tests: JSON.parse(this.test),
        questions: JSON.parse(this.ques),
        answers: JSON.parse(this.answ),
        time: JSON.parse(this.timer),
        selectedQuestion: null,
        questionsAnswers: [],
        b: 0,
        passed: false,
      }
    },
    created(){
      //console.log(this.tests,this.questions,this.answers,this.time);
      this.modifyQuestions();
      this.createQAObject();
      this.modifyAnswers();
    },
    methods:{

      modifyQuestions(){
        for (var key in this.questions){
          this.questions[key].active=false;
          this.questions[key].errorMessage="";
          this.questions[key].inputText="";
          //console.log(this.questions[key]);
        }
        this.tests.questions[0].active=true;
      },
      //выбор вопроса, на который будут даваться ответы
      selectQuestion(question){
        let questionId=question.id;
        var self=this;
        if (self.selectedQuestion!=questionId){
          self.modifyQuestions();
          question.active=true;
          self.b++;
          self.selectedQuestion=questionId;
        }
      },
      //выбор вариантов ответа на вопрос
      selectAnswer(answer,index){
        if (this.selectedQuestion!=null){
          answer.index=index;

          if (answer.id!=0){
            //проверяем, выбирали ли ответ до этого
            let check=this.checkSelectedAnswer(answer.id);
            if (check==1){
              this.questionsAnswers[this.searchQuestionIdIndex(this.selectedQuestion)].answers.push(answer);
              this.answersIsActive(answer.id,false);
            } else 
            if (check==0)
            {
              if (confirm('этот ответ уже был выбран, переставить его?')){
                for (var key in this.questionsAnswers){
                  for(var k in this.questionsAnswers[key].answers){
                    if (this.questionsAnswers[key].answers[k].id==answer.id){
                      this.questionsAnswers[key].answers.splice(k,1);
                    }
                  }
                }
                this.questionsAnswers[this.searchQuestionIdIndex(this.selectedQuestion)].answers.push(answer);
              }
            }
            //this.formData();
          }
          else{
            let check=this.checkSelectedAnswerNull(this.searchQuestionIdIndex(this.selectedQuestion));
            if (check>-1){
              // if (this.questionsAnswers[this.searchQuestionIdIndex(this.selectedQuestion)].answers.length>0){
              //   for (let key in this.questionsAnswers[this.searchQuestionIdIndex(this.selectedQuestion)].answers){
              //     let answer = this.questionsAnswers[this.searchQuestionIdIndex(this.selectedQuestion)].answers[key];
              //     this.extractAnswer(answer.id,this.searchQuestionIdIndex(this.selectedQuestion));
              //   }
                this.questionsAnswers[this.searchQuestionIdIndex(this.selectedQuestion)].answers.push(answer);
              //}
            }
          }
        } else {
          alert("Вопрос не выбран");
        }
      },
      //функция для проверки, был ли уже выбран вопрос, на который нажал пользователь
      checkSelectedAnswer(id){
        for (var key in this.questionsAnswers){
          for(var k in this.questionsAnswers[key].answers){
            if (this.questionsAnswers[key].answers[k].id==id){
              if (this.questionsAnswers[this.searchQuestionIdIndex(this.selectedQuestion)]==this.questionsAnswers[key]){
                return -1;
              }
              return 0;
            }
          }
        }
        return 1;
      },
      //проверка на наличие варианта нет правильных ответов в конкретном вопросе
      checkSelectedAnswerNull(indexQ){
        for (let k in this.questionsAnswers[indexQ].answers){
          let answer =this.questionsAnswers[indexQ].answers[k];
          if (answer.id==0){
            return -1;
          }
        }
        return 1;
      },
      modifyAnswers(answer){
        for (var key in this.answers){
          this.answers[key].active=true;
        }
      },
     
      questionsIsActive(id,flag){
        for (var key in this.tests.questions){
          if (this.tests.questions[key].id==id){
            this.tests.questions[key].active=flag;
          }
        }
      },
      answersIsActive(id,flag){
        for (var key in this.answers){
          if (this.answers[key].id==id){
            this.answers[key].active=flag;
          }
        }
      },
      createQAObject(){
        var self=this;
        this.questionsAnswers=[];
        for (var key in this.questions){
          this.questionsAnswers.push({
            question: this.questions[key].id,
            answers: new Array() 
          });
        }
        this.$nextTick(function(){

        });
      },
      //вспомогательная функция для поиска нужного элемента
      //массива по id вопроса
      searchQuestionIdIndex(id){
        for (var key in this.questionsAnswers){
          if (this.questionsAnswers[key].question==id){
            return key;
          }
        }
        return -1;
      },

      getAnswersByQuestionId(id){
        let searchedIndex=this.searchQuestionIdIndex(id);
        if (searchedIndex>-1){
          if (typeof(this.questionsAnswers[searchedIndex])=='object'){
            if (this.questionsAnswers[searchedIndex].hasOwnProperty('answers')){
              return this.questionsAnswers[searchedIndex].answers;
            }
          }
          
        }
        return [];
      },

      extractAnswer(idA,indexQ){
        //if (confirm('Ответ будет удален')){
          // var qaCurrent=this.questionsAnswers[this.searchQuestionIdIndex(idQ)];
          if (idA==0&&indexQ!=undefined){
            for (var key in this.questionsAnswers[indexQ].answers){
              if (this.questionsAnswers[indexQ].answers[key].id==idA){
                this.questionsAnswers[indexQ].answers.splice(key,1);
                break;
              }
            }
          } else {
            for (var k in this.questionsAnswers){
              for (var key in this.questionsAnswers[k].answers){
                if (this.questionsAnswers[k].answers[key].id==idA){
                  this.questionsAnswers[k].answers.splice(key,1);
                  break;
                }
              }
            }
            this.answersIsActive(idA,true);
          }
        //}
      },


      getResults(){
        this.passed=true;
        //console.log(this.questionsAnswers);
      },

      setInput(question){
        this.b++;
        
        //Проверка, был ли добавлен этот вопрос
        for (var k in this.questionsAnswers){
          for (var key in this.questionsAnswers[k].answers){
            let index= parseInt(this.questionsAnswers[k].answers[key].index);
            if (index==question.inputText) {
              question.errorMessage="Вопрос с таким номером уже добавлен";
              question.inputText="";
              return false;
            }
          }
        }
        //проверка, валидный ли индекс и добавление
        var indexIsValide=false;
        for (var k in this.answers){
          if (parseInt(k)+1==question.inputText){
            for (var key in this.questionsAnswers){ 
              if (this.questionsAnswers[key].question==question.id){
                this.selectAnswer(this.answers[k],parseInt(k)+1);
                indexIsValide=true;
                break;
              }
            }
          }
        }
        question.inputText="";
        if (!indexIsValide){
          question.errorMessage="Вопроса с таким номером нет!";
          return false;
        } else {
          question.errorMessage="";
        }
        return true;
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
      onPassed(){
        var red = '/pass/test/'+this.tests.id+'/result';
        let data=this.formData();

        redirect(red, {'idResult': this.idResult,'data': data , _token: $('[name="csrf-token"]').attr('content')},'POST');
      },
    },
    watch:{
      b(val){
        this.b=val>1000?val:this.b;
      },
      passed(val){
        if (val) {
          this.onPassed();
        }
      },
    },
    computed(){

    },
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