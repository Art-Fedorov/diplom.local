<template>
	<div class="archive">
		<div class="container">
			<div class="row">			
				<div class="col-md-12 " v-if="currentUser">
					<big style="margin-right: 10px"><b>{{currentUser.name}}</b> ({{getRoleName(currentUser.role)}})</big>
					
				</div>
				<div class="col-md-12 " v-if="currentUser">
					<form class="" style="display: inline-block;" @submit.prevent="submitForm">
						<big>Назначить пользователя</big>
						<select style="width: 66.66666%;" class="form-control col-sm-8" name="role" v-model="currentUser.role">
							<option value="user">Обычным пользователем</option>
							<option value="teacher">Редактором тестов</option>
							<option value="admin">Администратором</option>
						</select>
						<button type="submit" class="btn btn-primary col-sm-4">Назначить</button>
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
							<caption><h3>Пользователи ({{countActive}})</h3></caption>
							<thead>
								<tr>
									<th>Имя пользователя</th>
									<th>E-mail</th>
									<th>Права пользователя</th>
									<th>Дата регистрации</th>	
								</tr>
							</thead>
							<tbody>
								<tr v-show="!user.active" v-for="(user,index) in users" @click.prevent="selectUser(index)">
									<td>{{user.name}}</td>
									<td>{{user.email}}</td>
									<td>{{getRoleName(user.role)}}</td>
									<td>{{user.created_at}}</td>
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
		props: ['uss'],
		data(){
			return{
				currentUser: null,
				searchString: "",
				users: JSON.parse(this.uss),
				b: 0,
			}
		},
		created(){
		},
		methods:{
			getRoleName(str){
				if (str=='teacher') return 'Редактор тестов';
				if (str=='user') return 'Обычный пользователь';
				if (str=='admin') return 'Администратор';
			},
			submitForm(){
				this.$http.put('/api/user/update/'+this.currentUser.id,this.currentUser).then(function(response) {
					this.getUsers();
		          }, function(response) {
		              
		          });
			},
			selectUser(idx){
				this.currentUser=clonedeep(this.users[idx]);
				$("html, body").animate({ scrollTop: 0 }, "fast");
			},
			onSearch(str){
				let self=this;
				self.b++;
				let re = new RegExp(str, 'i');
				for (let key in self.users){
					let user=self.users[key];
					if (user.name.search(re)<0&&user.email.search(re)<0&&user.created_at.search(re)<0){
						self.users[key].active=true;
					} else {
						self.users[key].active=false;
					}
				}
			},
			getUsers(){
				this.$http.get('/api/user/all').then(function(response) {
					let self=this;
	            	self.users=response.data;
	            	self.b++;
		          }, function(response) {
		              
		          });
			},
		},
		computed:{
			countActive(){
				let k=0;
				for (let key in this.users){
					if (!this.users[key].active){
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