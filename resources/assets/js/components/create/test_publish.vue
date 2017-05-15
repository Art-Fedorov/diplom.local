<template>
  <div>
    
    <div v-if="!test.published" class="text-center">
      <h2 class="text-center test__header">Публикация теста "{{test.name}}"</h2>
      <div class="error__block" v-show="errorsCount>0">
        <h3 class="error__header test__header">Ошибки в тесте:</h3>
        <p class="error__item" v-for="error in errorsTest">
          Ошибка: {{error}}
        </p>
        <p class="error__item" v-for="error in errorsQuestions">
          Вопрос: 
            <a class="error__question" title="Изменить вопрос" @click.prevent="$parent.switchMainView('question-form',
                          { testId: test.id,
                            id: error.question.id, 
                            title: 'change' })" v-html="error.question.question"></a> <br>
          
          <span class="error__error">Ошибка: {{error.error}}</span>
        </p>
      </div>
      <div class="error__block" v-show="warningsCount>0">
        <h3 class="error__header test__header">Предупреждения:</h3>
        <p class="error__item" v-for="warning in warningsTest">
          {{warning}}
        </p>
        <p class="error__item" v-for="warning in warningsQuestions">
          Вопрос: <a class="error__question" @click.prevent="$parent.switchMainView('question-form',
                          { testId: test.id,
                            id: warning.question.id, 
                            title: 'change' })" v-html="warning.question.question"></a> <br>
          Предупреждение: {{warning.error}}
        </p>
      </div>
      <div class="publish__reminder text-left">
        <h4 class="publish__header">Перед публикацией проверьте данные о тесте еще раз!</h4>

        <div class="publish__item">
          Название теста: <span>{{test.name}}</span>
        </div>
        <div class="publish__item">
          Описание теста: <span>{{test.desc}}</span>
        </div>


        


        <div class="publish__item">
          Время на прохождение: <span>{{test.time}}</span>
        </div>
        <h5 class="publish__header publish__header--sm">Дополнительные настройки</h5>
        <div class="publish__item">
          Перемешивать порядок вопросов: 
          <span v-if="test.shuffle_questions">Да</span>
          <span v-else>Нет</span>
        </div>
        <div class="publish__item">
          Перемешивать порядок следования ответов: 
          <span v-if="test.shuffle_answers">Да</span>
          <span v-else>Нет</span>
        </div>
        <div class="publish__item" v-if="test.id_alg==1">
          Позволить произвольное перемещение по вопросам:
          <span v-if="test.pass_other_questions">Да</span>
          <span v-else>Нет</span>
        </div>
        <div class="publish__item" v-if="test.id_alg==1">
          Показывать, если правильных вариантов ответа больше одного:
          <span v-if="test.view_more_1_answer">Да</span>
          <span v-else>Нет</span>
        </div>
        <div class="publish__item">
          Показывать правильные ответы после прохождения теста: 
          <span v-if="test.view_right_answers">Да</span>
          <span v-else>Нет</span>
        </div>
        <div class="publish__item">
          <button class="btn btn-success publish__button publish__button--change" @click.prevent="$parent.switchMainView('test-form',
              { test: test,
                id: test.id, 
                title: 'Изменение теста', 
                button: 'Изменить тест' })">Изменить данные теста
          </button>
        </div>
      </div>




      <form  @submit.prevent="setPublish()">
        <div v-if="test.id_alg==2" class="form-group form-group--checkbox">
          <div class="col-md-4 col-sm-4  form-group__label">
            Количество показываемых вопросов в тесте
          </div>
          <div class="col-md-8 col-sm-8">
            <input type="number" min="1" :max="maxQuestions" v-model="test.count_questions" class="form-control">
          </div>
        </div>

        <div v-if="test.id_alg==2" class="form-group form-group--checkbox">
          <div class="col-md-4 col-sm-4  form-group__label">
            Количество показываемых ответов в тесте
          </div>
          <div class="col-md-8 col-sm-8">
            <input type="number" min="1" :max="maxAnswers" v-model="test.count_answers" class="form-control">
          </div>
        </div>

        <div class="form-group form-group--checkbox">
          <div class="col-md-4 col-sm-4  form-group__label">
            Публикация
          </div>
          <div class="col-md-8 col-sm-8">
            <select v-model="setDateStart" name="" id="" class="form-control">
              <option value="0" selected>Сразу</option>
              <option value="1">Выбрать дату</option>
            </select>
          </div>
        </div>
        <div v-if="setDateStart==1" class="form-group form-group--checkbox">
          <div class="col-md-4 col-sm-4  form-group__label">
            Дата публикации <br> (формат ГГГГ-ММ-ДД ЧЧ:ММ:СС):
          </div>
          <div class="col-md-8 col-sm-8">
            <input type="text" class="datepicker form-control" id="published_at" name="published_at" v-model="dateStart">
          </div>
        </div>
        <div class="form-group form-group--checkbox">
          <div class="col-md-4 col-sm-4  form-group__label">
            Окончание публикации
          </div>
          <div class="col-md-8 col-sm-8">
            <select v-model="setDateEnd" name="" id="" class="form-control">
              <option value="0" selected>Постоянная доступность</option>
              <option value="1">Выбрать дату</option>
            </select>
          </div>
        </div>
        <div v-if="setDateEnd==1" class="form-group form-group--checkbox">
          <div class="col-md-4 col-sm-4  form-group__label">
            Дата публикации <br> (формат ГГГГ-ММ-ДД ЧЧ:ММ:СС):
          </div>
          <div class="col-md-8 col-sm-8">
            <input type="text" class="datepicker form-control" id="published_at" name="published_at" v-model="dateEnd">
          </div>
        </div>
        <div class="form-group form-group--top">
          <div class="col-md-4 col-sm-4  form-group__label">
            Назначаемые группы
          </div>
          <div class="col-md-8 col-sm-8 text-left">
            <div class="mb5">
              <select v-model="selectedGroupId" name="id_group" class="form-control publish__groups-select">
                <option v-for="group in groups" :value="group.id">{{group.group}}</option>
              </select>
              <button class="btn btn-primary" @click.prevent="selectGroup">ОК</button>
            </div>
            <div class="publish__groups">
              <span class="publish__group" v-for="(group,index) in selectedGroups" @click="extractGroup(group,index)">{{group.group}}</span>
            </div>
            
          </div>
        </div>

        <div class="">
          <button type="submit" class="btn btn-success btn-lg publish__button" :disabled="errorsCount>0" :title="errorsCount>0?'В тесте есть ошибки':null">
            Опубликовать
          </button>
        </div>
      </form>
    </div>
    <div class="text-center" v-else>
      <h2 class="publish__header" v-if="!test.error">Тест {{test.name}} успешно опубликован</h2>
      <h3 class="publish__header danger" v-else>При публикации произошла ошибка</h3>
      <button class="btn btn-success btn-lg publish__button" @click.prevent="setUnPublish()">Отменить публикацию теста</button>
    </div>
  </div>
</template>
<script type="text/javascript">
  export default({
    props: ['array'],
    data(){
      return {
        test:{},
        name: "",
        testId: this.array.testId,
        errorsQuestions: [],
        warningsQuestions: [],
        errorsTest: [],
        warningsTest: [],
        setDateStart: 0,
        setDateEnd: 0,
        dateStart: null,
        dateEnd: null,
        groups: [],
        maxQuestions: 999,
        maxAnswers: 999,
        selectedGroups: [],
        selectedGroupId: null,
        b: 0,
      }
    },
    created(){
      var self=this;
      self.getTest();
      self.getGroups();
      self.initJquery();
    },
    methods:{
      
      checkTest(){
        var questions=this.test.questions;
        if (questions.length==0){
          let error= "В тесте нет ни одного вопроса";
          this.addTestError(1,error);
        } else {
          if (this.test.questions.length<5){
            let error= "В тесте меньше 5 вопросов, рекомендуемое минимальное количество - 8 вопросов";
            this.addTestError(0,error);
          }
          if (this.test.id_alg==1){
            for (let key in questions){
              if (questions[key].word==0){
                if (questions[key].answers.length>0){
                  let count = this.countRightAnswers(questions[key]);            
                  if (count==0){
                    let error = "В вопросе не выбран ни один правильный вариант ответа";
                    this.addQuestionError(1,questions[key],error);
                  } else if (count==questions[key].answers.length){
                    let error= "В вопросе правильны все варианты ответа";
                    this.addQuestionError(0,questions[key],error);
                  }
                } else{
                  let error= "В вопросе не добавлено ни одного варианта ответа";
                  this.addQuestionError(1,questions[key],error);
                  
                }
              }
            }
          } else if (this.test.id_alg==2) {
            for (let key in questions){
              if (questions[key].answers.length==0){
                let error= "В вопросе не добавлено ни одного варианта ответа";
                this.addQuestionError(1,questions[key],error);
              }
            }
          }
        }
      },
      countRightAnswers(question){
        let k=0;

        if (question.hasOwnProperty('answers')){
          // if (question.word==1){
          //   return 1;
          // }
          for (let key in question.answers){
            if (question.answers[key].iscorrect){
              k++;
            }
          }
        }

        return k;
      },
      // status - warning==0/error==1
      addQuestionError(status,question,message){
        let errorItem={
          question: question,
          error: message
        };
        if (status==0){
          this.warningsQuestions.push(errorItem);
        } else if (status==1){
          this.errorsQuestions.push(errorItem);
        }
      },
      addTestError(status,message){
        if (status==0){
          this.warningsTest.push(message);
        } else if (status==1){
          this.errorsTest.push(message);
        }
      },
      setUnPublish(){
        let data={
          published: 0,
          published_at: null,
          ended_at: null,
        };
        this.$http.put('/api/test/'+this.test.id, data).then(function(response) {
              this.test.published=0;
              this.test.published_at=null;
              this.$parent.$refs.testSidebar.getTests();

              this.$http.delete('/api/testgroups/'+this.test.id).then(function(){
                this.getGroups();
              },function(response){

              });
          }, function(response) {
              this.test.error=true;
          });
      },
      setPublish(){
        if(this.errorsCount!=0){
          alert('Нельзя опубликовать тест с ошибками!');
          return false;
        }
        if (this.selectedGroups.length<1){ 
          alert('Выберите хотя бы 1 группу');
          return false;
        }   
        if (this.dateEnd!=null){
          if (!checkDate(this.dateEnd)){
            alert('Неверная дата окончания публикации');
            return false;
          }
        }
        let date=this.dateStart;
        if (this.setDateStart==0){
          date=dateNow();
        }
        if (!checkDate(date)){
          alert('Неверная дата публикации');
          return false;
        }
        let data={
          published: 1,
          published_at: date,
          count_answers: this.test.count_answers,
          count_questions: this.test.count_questions,
        };
        if (this.dateEnd!=null){data.ended_at=this.dateEnd;}
        if (this.test.id_alg==2){
          data.count_answers=this.test.count_answers;
          data.count_questions=this.test.count_questions;
        }
        this.$http.put('/api/test/'+this.test.id, data).then(function(response) {
          this.test.published=1;
          this.test.published_at=date;
          this.$parent.$refs.testSidebar.getTests();
          let dataGroups=[];
          for (let key in this.selectedGroups){
            dataGroups.push({
              id_group: this.selectedGroups[key].id,
              id_test: this.test.id
            })
          }
          this.$http.post('/api/testgroups',dataGroups).then(function(){
            this.selectedGroups= [];
            this.selectedGroupId= null;
            return true;
          },function(response){
            return false;
          });
        }, function(response) {
            console.log(response.body);
            return false;
        });
      },
      getTest(){
        this.$http.get('/api/test/'+this.testId).then(function(response) {
            this.b++;
            this.test=response.data.test;
            this.name=this.test.algorithm.name;
            this.test.error=false;
            this.test.count_answers=this.test.count_answers!=undefined?this.test.count_answers:this.test.answers.length;
            this.test.count_questions=this.test.count_questions!=undefined?this.test.count_questions:this.test.questions.length;
            this.maxAnswers=this.test.answers.length;
            this.maxQuestions=this.test.questions.length;
            this.checkTest();
          }, function(response) {
              
          });
      },
      initJquery(){
        this.$nextTick(function(){
          $( ".datepicker" ).mask('0000-00-00 00:00:00',{
            placeholder: "____-__-__ __:__:__"
          });
        });
      },
      getGroups(){
        this.$http.get('/api/group').then(function(response) {
            this.b++;
            this.groups=response.data;
            this.selectedGroupId=this.groups[0].id||null;
          }, function(response) {
              
          });
      },
      selectGroup(){
        for (let group in this.groups){
          if (this.groups[group].id==this.selectedGroupId){
            this.selectedGroups.push(this.groups[group]);
            this.groups.splice(group,1);
            if (this.groups[parseInt(group)]!==undefined){
              this.selectedGroupId=this.groups[parseInt(group)].id||null;
            }
            break;
          }
        }
      },
      extractGroup(group,index){
        function sortById(a, b) {
          if (a.id > b.id) return 1;
          if (a.id < b.id) return -1;
        }
        this.groups.push(group);
        this.groups.sort(sortById);
        this.selectedGroups.splice(index,1);
        if (this.groups[parseInt(index)]!==undefined){
          this.selectedGroupId=this.groups[0].id||null;
        }
      }
    },
    computed:{
      errorsCount(){
        return this.errorsTest.length+this.errorsQuestions.length;
      },
      warningsCount(){
        return this.warningsTest.length+this.warningsQuestions.length;
      },      
    },
    watch: {
      array: function(val){  
        this.errorsQuestions= [];
        this.warningsQuestions= [];
        this.errorsTest= [];
        this.warningsTest= [];
        this.selectedGroups= [];
        this.testId= val.testId;
        this.getTest();
      },
      selectedGroupId(val){
        //console.log(val);
      },
      setDateStart(val){
        this.dateStart=dateNow();
        this.initJquery();
      },
      setDateEnd(val){
        this.dateEnd=dateWithWeek();
        this.initJquery();
      }
    },
  });




  function checkDate(str){
    let splitStr=str.split(' ');

    if (splitStr.length!=2) return false;

    let date=splitStr[0].split('-');
    let time=splitStr[1].split(':');

    if (date.length!=3||time.length!=3) return false;

    let y=date[0];
    let m=date[1];
    let d=date[2];
    let h=time[0];
    let min=time[1];
    let s=time[2];

    if (y< (new Date()).getFullYear()||y.search(/\d\d\d\d/i)<0||y.length!=4) {
      return false;
    }

    if (m< (new Date()).getMonth()+1||m.search(/\d\d/i)<0||m.length!=2||m<1||m>12) {
      return false;
    }

    if (!checkDay(y,m,d)) {
      return false;
    }

    if (h.search(/\d\d/i)<0||h.length!=2||h<0||h>23) {
      return false;
    }

    if (min.search(/\d\d/i)<0||min.length!=2||min<0||min>59) {
      return false;
    }

    if (s.search(/\d\d/i)<0||s.length!=2||s<0||s>59) {
      return false;
    }
    
    return true;
    
  }
  function checkDay(y,m,d){
    if (d<0||d>31)  { return false;}
    switch(parseInt(m)){
      case 4: case 6: case 9: case 11: 
        if (d>30) {
          return false; 
        }
        break;
      case 2: 
        if (this.checkLeapYear(y)&&d>29||!this.checkLeapYear(y)&&d>28){ 
          return false; 
        }
        break;
      default: break;
    }
    if (d< (new Date()).getUTCDate()||d.search(/\d\d/i)<0||d.length!=2) return false;
    return true;
  }
  //високосный ли год
  function checkLeapYear(y){
    if (y%4==0&&y%100!=0||y%400==0) return true;
    return false;
  }
  function dateNow(){
    let date=new Date();
    let yyyy=date.getFullYear(),
    mm=date.getMonth()+1<10?"0"+(date.getMonth()+1):date.getMonth()+1,
    dd=date.getDate()<10?"0"+date.getDate():date.getDate(),
    hh=date.getHours()<10?"0"+date.getHours():date.getHours(),
    min=date.getMinutes()<10?"0"+date.getMinutes():date.getMinutes(),
    ss=date.getSeconds()<10?"0"+date.getSeconds():date.getSeconds();
    return yyyy+"-"+mm+"-"+dd+" "+hh+":"+min+":"+ss;  
  }
  
  function dateWithWeek(){
    let date=new Date();
    date.setDate(date.getDate() + 7);
    let yyyy=date.getFullYear(),
    mm=date.getMonth()+1<10?"0"+(date.getMonth()+1):date.getMonth()+1,
    dd=date.getDate()<10?"0"+date.getDate():date.getDate(),
    hh=date.getHours()<10?"0"+date.getHours():date.getHours(),
    min=date.getMinutes()<10?"0"+date.getMinutes():date.getMinutes(),
    ss=date.getSeconds()<10?"0"+date.getSeconds():date.getSeconds();
    return yyyy+"-"+mm+"-"+dd+" "+hh+":"+min+":"+ss;  
  }
</script>