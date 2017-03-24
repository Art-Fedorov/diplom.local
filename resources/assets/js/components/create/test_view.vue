<template>
    <div class="sidebar">
        <h3>Список моих тестов</h3>
        <div class="sidebar-list">
            <div class="sidebar-list__item" v-for="(test,testIndex) in tests"> 
                <h4>{{test.name}}</h4>
                <a class="btn-sm btn-primary">Подробнее</a>
                <a 
                class="btn-sm btn-primary" 
                  @click.prevent="switchMainView('test-form',
                    { id: test.id, 
                      title: 'Изменение теста', 
                      button: 'Изменить тест' })">
                Редактировать
                </a>
                <a :href="'test/'+test.id+'/edit'" 
                class="btn-sm btn-primary" 
                  @click.prevent="deleteTest(test.id)">
                Удалить
                </a>
                <h5>Вопросы в тесте:</h5>
                <div class="list-row" v-for="question in test.questions">   
                    <div class="list-row__text">{{question.question}}</div>  
                    <a v-bind:href="'question/'+question.id+'/edit'" 
                      class="list-row__icon btn-sm btn-primary" 
                      @click.prevent="switchMainView('question-form',
                        { id: question.id, 
                          title: 'Изменение вопроса', 
                          button: 'Изменить вопрос' })">Р</a>
                    <a v-bind:href="'test'" 
                      class="list-row__icon btn-sm btn-primary" @click.prevent="deleteQuestion(question.id,testIndex)">X</a>        
                </div>
                <a v-bind:href="'question/'+test.id+'/create'" 
                class="btn-sm btn-primary"
                @click.prevent="switchMainView('question-form',
                { 
                  idTest: test.id,
                  title: 'Добавление вопроса', 
                  button: 'Добавить вопрос' })">
                Добавить вопрос
                </a>
            </div>    
        </div>
        <a href="#" class="btn btn-success">Показать еще</a>
        <a @click="switchMainView('test-form',{
                  title: 'Создание теста', 
                  button: 'Создать тест' })" 
           class="btn btn-success">Создать тест</a>

    </div>
</template>
<script>

export default({
    data: function(){
      
      return{
        tests: {},
        //currentMainView: 'test-form'
      };
    },
    created() {
      this.getTests();
    },
    methods: {
    switchMainView: function(view,ar = {}){
      this.$parent.switchMainView(view,ar);
    },
    getTests(){
      this.$http.get('/api/test')
        .then(function(response){
            this.tests=response.data.tests;
          },function(error){
            console.log(error);
          });
    },
    deleteQuestion(idQ,idT){
        this.$http.delete('/api/question/'+idQ).then(function(response) {
              this.tests[idT].questions = this.tests[idT].questions.filter(function( obj ) {
                return obj.id !== idQ;
              });
            }, function() {
                console.log('failed');
            });
    },
    deleteTest(idT){
        this.$http.delete('/api/test/'+idT).then(function(response) {
              this.tests = this.tests.filter(function( obj ) {
                return obj.id !== idT;
              });
              this.$parent.$refs.testSidebar.getTests();
            }, function() {
                console.log('failed');
            });
    }
  }
});

</script>