<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta id="token" value="{{ csrf_token() }}"> 
	<title>Todo</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
	<nav class="navbar navbar-default">
	  	<div class="container">
	    	<div class="navbar-header">
	      		<a class="navbar-brand" href="/">
	        		Todo App
	      		</a>
	    	</div>
	  	</div>
	</nav>

	<div class="container" id="app">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						Tasks todo
					</div>
				  	<div class="panel-body">
				    	<ul v-if="tasks.length >= 1">
				    		<li v-for="task in tasks">
						    	<span>@{{ task.description }}</span>
						    	<br/>
						      	<button class="btn-xs btn-danger" v-on:click="removeTask($index, task.id)">Delete</button>
						    </li>
				    	</ul>
				    	<h3 v-else>
				    		There is no tasks to do!
				    	</h3>
				  	</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						Create new tasks
					</div>
				  	<div class="panel-body">
				    	<div class="form-group">
				    		<input type="text" class="form-control" placeholder="Add Your Task" v-model="task.description">
				    	</div>
				    	<button class="btn btn-primary" v-on:click="addTask">Add Task</button>
				  	</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/vue/1.0.25/vue.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.9.1/vue-resource.min.js"></script>
	<script>
		//Our JS Code Will be On Here!
		Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');
		Vue.config.debug = true;

		new Vue({
			el: '#app',

			data: {
				task: { description: '' },
  				tasks: []
			},

			ready: function() {
				this.fetchTasks();
			},

			methods: {
				fetchTasks: function() {
				    // var tasks = [
				    //   	{
						  //     id: 1,
						  //     description: 'Write article',
				    //   	},
				    //   	{
				    // 	     	id: 2,
				    // 	     	description: 'Learn something new',
				    //   	},
				    //   	{
				    // 	     	id: 3,
				    // 	     	description: 'Read article',
				    //   	}
				    // ];
				    // this.$set('tasks', tasks);

					this.$http.get('/tasks').then((tasks) => {
						// success callback
						this.$set('tasks', tasks.data);
				    }, (error) => {
				        // error callback
				        console.log(error);
				    });
				},
				addTask: function () {
			      	if(this.task.description) {
				      	// this.tasks.push(this.task);
				      	// this.task = { description: '' };

				      	this.$http.post('addtask', this.task).then((response) => {
					        this.tasks.push(response.data);
						  	this.task = { description: '' };

						}, (error) => {
					    	console.log(error);
					    });
				    }
			    },
				removeTask: function (index, id) {
					if(confirm("Are you sure you want to delete this task?")) {
					    // this.tasks.splice(index, 1);

					    this.$http.delete('/deletetask/' + id).then((response) => {
							// success callback
							this.tasks.splice(index, 1);
					    }, (error) => {
					        // error callback
					        console.log(error);
					    });
					}
			    }
			}
		});
	</script>
</body>
</html>