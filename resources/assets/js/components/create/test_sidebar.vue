<template>
  <div class="sidebar">
    <a title="Создать новый тест" @click.prevent="$parent.switchMainView('test-form',{
              
              title: 'add' })" 
       class="btn-success fa fa-plus sidebar__add-test"></a>
    <div class="sidebar__filter-header">Фильтр</div>
    <div class="sidebar__filter">
      <a class="btn btn-sm btn-primary sidebar__filter-button" :class="{'active': category==1}" @click.prevent="changeTestsCategory(1)">Классические тесты</a>
      <a class="btn btn-sm btn-primary sidebar__filter-button" :class="{'active': category==2}" @click.prevent="changeTestsCategory(2)">Тесты-сопоставления</a>
      <a class="btn btn-sm btn-primary sidebar__filter-button" :class="{'active': category==0}" @click.prevent="changeTestsCategory(0)">Все тесты</a>
    </div>
    <div class="sidebar__tests">
      <sidebar-group nullMessage="Пока что нет созданных тестов" :tests="tests" :header="'Неопубликованные тесты'"></sidebar-group>
      <sidebar-group nullMessage="Пока что нет опубликованных тестов" :tests="publishedTests" :header="'Опубликованные тесты'"></sidebar-group>
      <sidebar-group nullMessage="Пока что нет пройденных тестов" :tests="archiveTests" :header="'Пройденные тесты'"></sidebar-group>

    </div>
    <div class="hide">{{b}}</div>
    <div v-if="error"><h2>Перезагрузите страницу. При загрузке данных произошла ошибка.</h2></div>
  </div>
</template>
<script>
import testSidebarGroup from "./test_sidebar-group.vue";
export default({
  components:{
    'sidebar-group':testSidebarGroup
  },
  props:
    ['id_user'],
  
  data: function(){
    
    return{
      tests: [],
      visibleTests: [],
      publishedTests: [],
      archiveTests: [],
      category: 0,
      b: 0,
      error: null
    };
  },
  created() {
    this.getTests();
    //console.log(this.archiveTests);
    //console.log(this.idUser);
  },
  methods: {
    /*
    * Смена главного компонента
    */ 
    
    getTests(){
      //Тут дерьмо
      var idUser = this.id_user;
      var data={'id_user': idUser};
      this.$http.get('/api/test',{params: data})
        .then(function(response){
          var receive = response.data.tests;
          this.publishedTests=[];
          for (var keyRec in receive)
          {
            this.b++;
            //receive[keyRec].expand=false;
            receive[keyRec].showed=true;
            var oldTest=false;

            //Если тест не идет в архив
            if (receive[keyRec].archive==0){
              //Если тест опубликован
              if (receive[keyRec].published){
                this.tests=this.tests.filter(function(obj){
                  return receive[keyRec].id!=obj.id;
                });
                for (var key in this.publishedTests){
                  if (this.publishedTests[key].id == receive[keyRec].id){
                    oldTest=true;
                    for (var prop in this.publishedTests[key]){
                      if (prop=="questions"||prop=="showed"||prop=="expand") continue;
                      this.publishedTests[key][prop]=receive[keyRec][prop];
                    }
                    // for (var keyRecQ in receive[keyRec].questions){
                    //   //console.log($.parseHTML(receive[keyRec].questions[keyRecQ].question));
                    //   var oldQuestion=false;
                    //   for (var keyQ in this.publishedTests[key].questions){
                    //     if (this.publishedTests[key].questions[keyQ].id == receive[keyRec].questions[keyRecQ].id){
                    //       this.publishedTests[key].questions[keyQ]=receive[keyRec].questions[keyRecQ];
                    //       oldQuestion=true;
                    //     }
                    //   }
                    //   if (!oldQuestion){
                    //     this.publishedTests[key].questions.push(receive[keyRec].questions[keyRecQ]);
                    //   }
                    // }
                  }
                }
                if (!oldTest){
                  this.publishedTests.push(receive[keyRec]);
                }
              //Если тест не опубликован
              } else{

                for (var key in this.tests){

                  //Если совпадают id теста и текущего полученного теста, 
                  //а также совпадают значения опубликованности, то тест старый
                  //и просто присваиваем его поля, которые могли обновиться
                  if (this.tests[key].id == receive[keyRec].id&&this.tests[key].published == receive[keyRec].published){
                    oldTest=true;
                    for (var prop in this.tests[key]){
                      if (prop=="questions"||prop=="showed"
                        //||prop=="expand"
                        ) continue;
                      this.tests[key][prop]=receive[keyRec][prop];
                    }

                    //Вопросики
                    // for (var keyRecQ in receive[keyRec].questions){
                    //   var oldQuestion=false;

                    //   for (var keyQ in this.tests[key].questions){
                    //     if (this.tests[key].questions[keyQ].id == receive[keyRec].questions[keyRecQ].id){
                    //       this.tests[key].questions[keyQ]=receive[keyRec].questions[keyRecQ];
                    //       oldQuestion=true;
                    //     }
                    //   }
                    //   if (!oldQuestion){
                    //     this.tests[key].questions.push(receive[keyRec].questions[keyRecQ]);
                    //   }
                    // }
                  }
                }
                if (!oldTest){
                  this.tests.push(receive[keyRec]);
                }
              }
            } else {
              this.publishedTests=this.publishedTests.filter(function(obj){
                return receive[keyRec].id!=obj.id;
              });
              let f=false;
              for (var k in this.archiveTests){
                if (this.archiveTests[k].id==receive[keyRec].id){
                  f=true;
                }
              }
              if (!f) this.archiveTests.push(receive[keyRec]);
              //console.log('asd');
            }
          }

          //Удаление теста
          for (var key in this.tests){
            let f=false;
            for (let k in receive){
              if (this.tests[key].id==receive[k].id){
                f=true;
              }
            }    
            if (!f){
              this.tests.splice(key,1);
            }   
          }           
        },function(error){
          //console.log(error.body);
          this.error=true;
        });
    },



    deleteQuestion(idQ,test,localTests){
        this.$http.delete('/api/question/'+idQ).then(function(response) {
              let testId=test.id;
              for (var key in this.tests){
                if (this.tests[key].id==testId){
                  this.tests[key].questions = this.tests[key].questions.filter(function( obj ) {
                    return obj.id !== idQ;
                  });
                  break;
                }
              }
              for (var key in this.publishedTests){
                if (this.publishedTests[key].id==testId){
                  this.publishedTests[key].questions = this.publishedTests[key].questions.filter(function( obj ) {
                    return obj.id !== idQ;
                  });
                  break;
                }
              }
              
            }, function() {
                console.log('failed');
            });
    },

    setExpand(test){
      this.b++;
      test.expand=!test.expand;
    },

    showAllButton(id){
      return Object.keys(this.tests[id].questions).length>2;
    },

    changeTestsCategory(num){
      this.category=num;
    },
    switchTestInfo(test){
      this.$parent.switchMainView('test-info',
        {
          wasCreated: false,
          testId: test.id
        });
    },
  },
  computed:{
  },
  watch:{
    category(val){
      for (var key in this.tests){
        if (this.tests[key].id_alg!=val&&val!=0) {
          this.tests[key].showed=false;
        } else {
          this.tests[key].showed=true;
        }
      }
      for (var key in this.publishedTests){
        if (this.publishedTests[key].id_alg!=val&&val!=0) {
          this.publishedTests[key].showed=false;
        } else {
          this.publishedTests[key].showed=true;
        }
      }
      for (var key in this.archiveTests){
        if (this.archiveTests[key].id_alg!=val&&val!=0) {
          this.archiveTests[key].showed=false;
        } else {
          this.archiveTests[key].showed=true;
        }
      }
      this.b++;
    },
    b(val){
      if (val>100){
        this.b=0;
      }
    },
    tests(val){
    }
  }
});
</script>