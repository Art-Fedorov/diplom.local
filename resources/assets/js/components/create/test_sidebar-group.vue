<template>
  <div class="sidebar__tests-group">
    <div class="sidebar__header">{{header}}</div>
    <transition>
      <div class="sidebar__list" v-if="tests.length>0">
        <div class="sidebar__list-item" v-for="(test,testIndex) in tests" v-show="test.showed"> 
          <a class="sidebar__list-item-header" @click.prevent="$parent.switchTestInfo(test)" title="Просмотреть подробную информацию о тесте">{{test.name}}</a>   
          <i v-if="test.archive!=0||test.published!=0" class="sidebar__icon sidebar__icon--green fa fa-group" 
            @click.prevent="$parent.$parent.switchMainView('add-groups',
             { testId: test.id })" 
            title="Изменение групп, для которых опубликован тест">
          </i>
          <i v-if="test.archive==0&&test.published==0" class="sidebar__icon sidebar__icon--green fa fa-pencil" 
            
            @click.prevent="$parent.$parent.switchMainView('test-form',
              { 
                id: test.id, 
                title: 'change' })" 
            title="Редактировать">
          </i>
          <i v-if="test.archive==0" class="sidebar__icon sidebar__icon--blue fa fa-newspaper-o"
            @click.prevent="$parent.$parent.switchMainView('test-publish',
              { testId: test.id })" 
            :title="test.published?'Отменить публикацию':'Опубликовать тест'">
          </i>
          <i v-if="test.published==0" class="sidebar__icon sidebar__icon--orange fa fa-plus" 
            @click.prevent="addQuestion(test)" 
            title="Добавить вопрос">
          </i>
          <!-- <i v-if="test.archive==0" class="sidebar__icon sidebar__icon--orange fa" 
            :class="{'fa-toggle-off' : !test.expand, 'fa-toggle-on': test.expand}" 
            @click.prevent="$parent.setExpand(test)" 
            :title="test.expand?'Скрыть вопросы':'Показать вопросы'">
          </i>
          <transition name="slide-fade">
            <div class="sidebar__questions" v-if="test.archive==0" v-show="test.expand">
              <h5 class="sidebar__question-header">Вопросы в тесте:</h5>
              <transition>
                <div v-if="test.questions.length>0">
                  <transition-group name="list-complete" tag="div">
                    
                    <a v-for="(question,index) in test.questions" v-bind:key="question.id" title="Изменить вопрос"  
                         class="sidebar__question"
                          @click.prevent="$parent.$parent.switchMainView('question-form',
                          { testId: test.id,
                            id: question.id, 
                            title: 'change' })" >
                      {{parseInt(index)+1}}
                      <span v-html="question.question"></span>
                    </a>                     
                  </transition-group>
                </div>
                <div v-else>Не добавлено ни одного вопроса</div>
              </transition>
              <div class="text-left sidebar__question-button">
                <a
                class="btn-sm btn-primary"
                @click.prevent="addQuestion(test)">
                Добавить вопрос
                </a>
              </div>
            </div>
          </transition> -->
        </div> 
      </div>
      <div v-else>
        <h4>{{nullMessage}}</h4>
      </div>
    </transition>
  </div>
</template>
<script type="text/javascript">
  export default({
    props: ['tests','header','noquestions','nullMessage'],
    created(){
    },
    methods: {
      addQuestion(test){

        this.$parent.$parent.switchMainView('question-form',
          { testId: test.id,
            title: 'add' });
        if (this.$parent.$parent.$refs['question-form']!=undefined){
          this.$parent.$parent.$refs['question-form'].onArrayChange({ testId: test.id,
            title: 'add' });
        }
      },
    },
  })
</script>