<template>
	<div class="archive">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h3 class="text-center" v-if="newGroup.id">Изменение группы</h3>
					<h3 class="text-center" v-else>Добавление группы</h3>
					<form @submit.prevent="submitGroup">
						<div class="form-group">
					        <div class="col-md-4 col-sm-4 form-group__label">
					          	Название группы
					        </div>
					        <div class="col-md-8 col-sm-8">
					          	<input class="form-control" type="text" autocomplete="false" name="group" 
					          v-model="newGroup.group" required/>
					        </div>
					    </div>
						<div class="form-group">
					        <div class="col-md-4 col-sm-4 form-group__label">
					          	Описание группы
					        </div>
					        <div class="col-md-8 col-sm-8">
					          	<input class="form-control" type="text" autocomplete="false" name="desc" 
					          v-model="newGroup.desc" required/>
					        </div>
					    </div>
					    <div class="form-group">
					        <div class="col-md-4 col-sm-4 form-group__label">
					          	Дата образования
					        </div>
					        <div class="col-md-8 col-sm-8">
					          	<input class="form-control" type="text" autocomplete="false" name="start_year" 
					          v-model="newGroup.start_year" />
					        </div>
					    </div>
					    <div class="form-group">
					        <div class="col-md-4 col-sm-4 form-group__label">
					          	Дата выпуска
					        </div>
					        <div class="col-md-8 col-sm-8">
					          	<input class="form-control" type="text" autocomplete="false" name="end_year" 
					          v-model="newGroup.end_year" />
				        	</div>
					    </div>
					    <div class="text-center">
					        <button type="submit" class="btn btn-success">Сохранить</button>
				      	</div>
					</form>
				</div>
				<div class="col-md-12">
					<div class="archive__filter">
						<div class="archive__filter-item">
							<label class="col-sm-3 form-group__label" for="">Поиск</label>
							<input class="col-sm-5 form-control" type="text" v-model="searchString">
							<button class="col-sm-4 btn btn-primary" @click="onSearch(searchString)">Искать</button>
						</div>
					</div>
					
					<div class="col-md-12">
						<table class="table">
							<caption><h3>Группы ({{countActive}})</h3></caption>
							<thead>
								<tr>
									<th>Название группы</th>
									<th>Описание группы</th>
									<th>Дата образования</th>
									<th>Дата выпуска</th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="!group.active" v-for="(group,index) in groups" @click.prevent="selectEditedGroup(index)">
									<td>{{group.group}}</td>
									<td>{{group.desc}}</td>
									<td>{{group.start_year}}</td>
									<td>{{group.end_year}}</td>
								</tr>
							</tbody>
						</table>
						
					</div>
				</div>
			</div>
		</div>
		<div class="hidden">{{b}}</div>
	</div>
</template>
<script>
	export default({
		props: ['gro'],
		data(){
			return{
				newGroup: {
					id: null,
					group: null,
					desc: null,
					start_year: dateNow(),
					end_year: dateWithYears(4),
				},
				searchString: "",
				groups: JSON.parse(this.gro),
				b: 0,
			}
		},
		created(){

		},
		methods:{
			onSearch(str){
				let self=this;
				self.b++;
				let re = new RegExp(str, 'i');
				for (let key in self.groups){
					let group=self.groups[key].group;
					if (group.search(re)<0){
						self.groups[key].active=true;
					} else {
						self.groups[key].active=false;
					}
				}
			},
			deleteGroup(idx){
				let self=this;
				let group = clone(self.groups[idx]);
				if (confirm('Вы действительно хотите удалить группу "'+group.group+'"')){
					self.groups.splice(idx,1);
					self.b++;
				}
			},
			nulledNewGroup(){
				this.newGroup= {
					id: null,
					group: null,
					desv: null,
					start_year: null,
					end_year: null,
				};
			},
			getGroups(){
				this.$http.get('/api/group/all').then(function(response) {
					let self=this;
	            	self.groups=response.data;
	            	self.b++;
		          }, function(response) {
		              
		          });
			},
			selectEditedGroup(index){
				this.newGroup=clonedeep(this.groups[index]);
				$("html, body").animate({ scrollTop: 0 }, "fast");
			},
			submitGroup(){
				if (!this.newGroup.id){
					this.$http.post('/api/group/store',getNotNulledData(this.newGroup)).then(function(response) {
							this.getGroups();
		          }, function(response) {
		              
		          });
				} else {
					this.$http.put('/api/group/update/'+this.newGroup.id,getNotNulledData(this.newGroup)).then(function(response) {
							this.getGroups();

		          }, function(response) {
		              
		          });
				}
			}
		},
		computed:{
			countActive(){
				let k=0;
				for (let key in this.groups){
					if (!this.groups[key].active){
						k++;
					}
				}
				return k;
			}
		}
	});


	function dateNow(){
    let date=new Date();
    let yyyy=date.getFullYear(),
    mm=date.getMonth()+1<10?"0"+(date.getMonth()+1):date.getMonth()+1,
    dd=date.getDate()<10?"0"+date.getDate():date.getDate();
    return yyyy+"-"+mm+"-"+dd;  
  };
  
  function dateWithYears(y){
    let date=new Date();
    date.setDate(date.getYear() + y);
    let yyyy=date.getFullYear(),
    mm=date.getMonth()+1<10?"0"+(date.getMonth()+1):date.getMonth()+1,
    dd=date.getDate()<10?"0"+date.getDate():date.getDate();
    return yyyy+"-"+mm+"-"+dd;  
  };

	function getNotNulledData(obj){
		for (let key in obj){
			if (obj[key]==null){
				delete obj[key];
			}
		}
		return (obj);this.getNotNulledData()
	};
	function getFormData($form){
	    var unindexed_array = $form.serializeArray();
	    $.each($($form).find('input[type=checkbox]')
	      .filter(function(idx){
	          return $(this).prop('checked') === false
	      }),
	      function(idx, el){
	          // attach matched element names to the formData with a chosen value.
	          unindexed_array.push({name:$(el).attr('name'),value:0});
	      }
	    );
	    var indexed_array = {};
	    $.map(unindexed_array, function(n, i){
	        n['value']=n['value']=='on'?1:n['value'];
	        indexed_array[n['name']] = n['value'];
	    });

	    return indexed_array;
	}
</script>