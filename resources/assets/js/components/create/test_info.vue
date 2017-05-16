<template>
  <div class="test-info">
    <div v-if="array.wasCreated">
      <h2 class="test__header">Тест "{{test.name}}" успешно создан</h2>
    </div>
    <div class="test__header" v-else>
      <h2>Тест "{{test.name}}"</h2>
    </div>
    <div class="publish__reminder text-left">
      <div class="publish__item" v-if="test.desc">
        Описание теста: <span>{{test.desc}}</span>
      </div>

      <div class="publish__item">
        Категория представления теста: 
        <span>{{name}}</span>
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
        <span >
          <span v-if="test.pass_other_questions">Да</span>
          <span v-else>Нет</span>
        </span>
      </div>
      <div class="publish__item" v-if="test.id_alg==1">
        Показывать, если правильных вариантов ответа больше одного:
        <span >
          <span v-if="test.view_more_1_answer">Да</span>
          <span v-else>Нет</span>
        </span>
      </div>
      <div class="publish__item">
        Показывать правильные ответы после прохождения теста: 
        <span v-if="test.view_right_answers">Да</span>
        <span v-else>Нет</span>
      </div>
      <div class="publish__item">
        <button v-if="test.archive!=0||test.published!=0" class="btn btn-success publish__button publish__button--change" 
        title="Изменить список групп, для которых опубликован тест"
        @click.prevent="$parent.switchMainView('add-groups',
             { testId: test.id })" >Изменить группы
        </button>
        <button v-if="!test.published" class="btn btn-success publish__button publish__button--change" @click.prevent="$parent.switchMainView('test-form',
            { testId: test.id,
              id: test.id, 
              title: 'change' })">Изменить данные теста
        </button>
        <button v-if="!test.published" 
                class="btn btn-success publish__button publish__button--change" 
          @click.prevent="$parent.deleteTest(test.id)">
        Удалить
        </button>
      </div>
    </div>
    <div class="info__header-container">
      <h4 class="info__header">Вопросы в тесте:</h4> 
      <button v-if="!test.published" class="info__header-icon fa fa-plus btn-primary" 
          title="Добавить вопрос"
          @click.prevent="$parent.switchMainView('question-form',
                { testId: test.id,
                  title: 'add' })">
      </button>
    </div>
    <div class="info__question-container" v-for="(question,idx) in test.questions" v-if="test.questions.length">
      <h4 class="info__question-item" v-if="!test.published">
        <a title="Удалить вопрос" class="info__delete-question question__icon fa fa-close btn-primary" @click.prevent="deleteQuestion(question,idx)"></a>
        <span class="info__question-number">{{parseInt(idx)+1}}</span>
        <span class="info__question" title="Изменить вопрос" @click.prevent="$parent.switchMainView('question-form',
                        { testId: test.id,
                          id: question.id, 
                          title: 'change' })" v-html="question.question"></span>
        
      </h4>
      <h5 v-else>
        <span class="info__question-number">{{parseInt(idx)+1}}</span>
        <span class="info__question" v-html="question.question"></span>
      </h5>
      
      <div class="info__answers" v-if="question.answers.length">
        <h5 class="info__answer-header">Ответы:</h5>
        <div v-for="(answer,index) in question.answers">
          <span class="info__answer" :class="{active : answer.iscorrect}"  :title="answer.iscorrect?'Верный ответ':'Неверный ответ'">
          {{parseInt(index)+1}}. {{answer.answer}}
          </span>
        </div>
      </div>
      <div class="info__answers" v-else><h5 class="info__answer">Ответы еще не добавлены</h5><a class="btn-link" @click.prevent="$parent.switchMainView('question-form',
                        { testId: test.id,
                          id: question.id, 
                          title: 'change' })">Добавить</a></div>
    </div>
    <div v-else>
      <h5>В этом тесте еще нет вопросов</h5>
    </div>
    <div class="extra__buttons" v-show="test.id">
      <div v-if="!test.published" class="extra__button">
        <button  class="btn btn-sm btn-primary"
                @click.prevent="$parent.switchMainView('question-form',
                { testId: test.id,
                  title: 'add' })">
                Добавить вопрос
        </button>
      </div>
    </div>
    <div class="info__button">
        <button v-if="!test.published" v-show="!array.wasCreated" class="btn btn-success" 
          @click.prevent="$parent.switchMainView('test-publish',
              { testId: test.id })">Перейти к публикации теста
        </button>
        <button v-if="test.published" v-show="!array.wasCreated" class="btn btn-success" 
          @click.prevent="$parent.switchMainView('test-publish',
              { testId: test.id })">Перейти к отмене публикации теста
        </button>
        <!-- <button v-if="test.archive" v-show="!array.wasCreated" class="btn btn-success" 
          @click.prevent="$parent.switchMainView('test-publish',
              { test: test })">
        </button> -->
      </div>
    <div class="hidden">{{b}}</div>
  </div>
</template>
<script type="text/javascript">

  const popup = require('./popup.vue');
  export default({
    components: {
      'popup':popup,
    },
    props: ['array'],
    data(){
      return {
        b: 0,
        test: {},
        name: "",
      }
    },
    created(){
      let self=this;
      self.getTest();
    },
    watch:{
      array(val){
        this.getTest();
        this.array.wasCreated=val.wasCreated==true?true:false;
        
      },
      test(val){

      },
      b(val){
        this.b=val>1000?0:val;
      }

    },
    methods:{
      getTest(){
        this.$http.get('/api/test/'+this.array.testId).then(function(response) {
            let self=this;
            self.test.delete=false;
            for (let key in self.test.questions){
              self.test.questions[key].delete=false;
            }
            self.b++;
            self.test=response.data.test;
            self.name=self.test.algorithm.name;
          }, function(response) {
              
          });
      },
      showModal(f,obj){
        let self=this;
        self.b++;
        if (f=='t'){
          self.test.delete=true;        
        } else if (f=='q'){
          obj.delete=true;
        }
      },
      deleteQuestion(question,idx){
        if (confirm('Вы действительно хотите удалить вопрос?')){
          let self=this;
          self.b++;
          question.delete=false;
          this.$parent.$refs.testSidebar.deleteQuestion(question.id,this.test);
          this.test.questions.splice(idx,1);
        }
      },
      deleteAnswer(){

      },
      deleteTest(){
        let self=this;
        self.test.delete=false;
        self.b++;
        this.$http.delete('/api/test/'+this.test.id).then(function(response) {
          var self=this;       
          self.$parent.switchPrevious();
          self.$parent.$refs.testSidebar.getTests();
        }, function() {
            console.log('failed');
        });
        
      },
    }
  });
</script>