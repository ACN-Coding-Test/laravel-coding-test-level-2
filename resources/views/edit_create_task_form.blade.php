
<?php 
$project_id = "";
$task_title = "";
$task_id = "";
$task_description = "";
$assigned_to = "";
$project_name = "";
$task_status = "";
if(isset($tasks))
{
    $task_title = $tasks->title;
    $task_description = $tasks->description;
    $project_name = $tasks->project_name;
    $task_status = $tasks->status;
    $task_id = $tasks->task_id;
    $project_id = $tasks->project_id;
}
?>


<div class="justify-content-center">
    <div class="card">
        <div class="card-body">
        <form action="{{ route('updateTask') }}" method="POST">
            @csrf
            <input type="hidden" name="hid_task_id" value="{{ $task_id }}">
            <input type="hidden" name="hid_project_id" value="{{ $project_id }}">
            <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3"><label>Project name <span class="red-mark">*</span></label></div>
                        <div class="col-md-9">
                            <label>{{ $project_name }}</label>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3"><label>Task Status</label></div>
                        <div class="col-md-9">
                           
                            <select name="update_task_status" >
                                        <option value="0"
                                        {{ $task_status == 0 ? "selected" : "" }}
                                        >Not started</option>
                                        <option value="1" {{ $task_status == 1 ? "selected" : "" }}>In Progress</option>
                                        <option value="2" {{ $task_status == 2 ? "selected" : "" }}>Ready to test</option>
                                        <option value="3" {{ $task_status == 3 ? "selected" : "" }}>Completed</option>
                                    </select>
                            
                        </div>
                    </div>
                    @isset( $logged_in_user)
                    <!-- condition to show create new project button to Admin and Product owner only --> 
                        @if( $logged_in_user->user_type == 1)
                        <hr>
                        <div class="row">
                            <div class="col-md-3"><label>Assign To</label></div>
                            <div class="col-md-9">
                            <select class="select2-user form-control" name="user_id" multiple="multiple"
                                id="select2-user">
                                <?php 
                                if (is_countable($users) && count($users) > 0) 
                                {
                                    foreach($users as $data1)
                                    {
                                ?>
                                <option value="{{ $data1-> id }}">{{ $data1-> name }}</option>
                                <?php 
                                    } 
                                }
                                ?>               
                            </select>
                            </div>
                        </div>
                        @endif
                    @endif
                    <hr>
                    <div class="row">
                        <div class="col-md-3"><label>Title <span class="red-mark">*</span></label> </label></div>
                        <div class="col-md-9">
                            <input type="text" name="title" class="form-control" placeholder="Enter Title" required value="{{ $task_title }}" />
                            
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3"><label>Description <span class="red-mark">*</span></label></label></div>
                        <div class="col-md-9">
                            <textarea type="text" name="description" class="form-control" placeholder="Enter Description">{{ $task_description }}</textarea>
                        </div> 
                    </div>
                    <hr>
                    <div class="row">
                        <div class="d-grid mx-auto">
                            <button type="submit" class="btn btn-dark btn-block">Create Task</button>
                        </div>
                    </div>
            </div>
        </form>
        </div>
    </div>
</div>

