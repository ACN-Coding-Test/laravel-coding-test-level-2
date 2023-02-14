@include('sidebar')
@include('navbar')

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
        <div class="card-title">List of Tasks</div>
        <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> Task title </th>
                            <th> Description </th>
                            <th> Project </th>
                            <th> Status </th>
                            <th> Assigned to </th>
                            <th> Action </th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                            if(count($tasks)>0)
                            {
                                foreach($tasks as $data)
                                {
                            ?>
                          <tr>
                            <td>
                                {{ $data->title }}
                            </td>
                            <td> {{ $data->description }} </td>
                            <td> {{ $data->project_name }} </td>
                            <td @isset($logged_in_user) @if( $logged_in_user->user_type == 2) onclick="update_task_status({{ $data->task_id }} @endif @endif)"> 
                                <div class='badge show_status_{{ $data->task_id }}
                                    {{ (
                                    ($data->status == 0) ? "badge-danger" :
                                    (($data->status == 1) ? "badge-warning" :
                                    (($data->status == 2) ? "badge-info" : "badge-outline-success"))
                                    ) }}

                                    '>{{ (
                                    ($data->status == 0) ? "Not started" :
                                    (($data->status == 1) ? "In Progress" :
                                    (($data->status == 2) ? "Ready to test" : "Completed"))
                                    ) }}
                                </div>
                                @isset($logged_in_user) @if( $logged_in_user->user_type == 2) 
                                <div class="update_status_{{ $data->task_id }}" style="display:none">
                                    <select name="update_task_status" onchange="fun_change_task_status({{ $data->task_id }}, this.value)">
                                        <option value="0"
                                        {{ $data->status == 0 ? "selected" : "" }}
                                        >Not started</option>
                                        <option value="1" {{ $data->status == 1 ? "selected" : "" }}>In Progress</option>
                                        <option value="2" {{ $data->status == 2 ? "selected" : "" }}>Ready to test</option>
                                        <option value="3" {{ $data->status == 3 ? "selected" : "" }}>Completed</option>
                                    </select>
                                </div>
                                @endif @endif
                            </td>
                            <td>
                                {{ $data->name }} 
                            </td>
                            <td onclick="fun_open_task_details({{ $data->task_id }})"><a href="#" title="Edit Task"><i class="mdi mdi-table-edit"></i></a></td>
                          </tr>
                            <?php 
                                } 
                            } else {
                            ?>
                            <tr><td colspan="6" align="center">No tasks available..!</td></tr>
                            <?php 
                            }
                            ?>  
                         
                        </tbody>
                      </table>
                    </div>
        </div>
    </div>
</div>

<!-- modal window -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModal">Create new Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     
      </div>
    </div>
  </div>
</div>

<script>
function update_task_status(taskId)
{
    $(".show_status_"+taskId).hide();
    $(".update_status_"+taskId).show();
}

/* function to update task status */
function fun_change_task_status(taskId,status)
{
    if (confirm("Are you sure you want to change status of task ?")) {
        //txt = "You pressed OK!";
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ url('/changeStatus') }}",
            data: {
                'status': status, 
                'task_id': taskId,
                '_token': "{{ csrf_token() }}",
            },
            success: function(data){
                location.reload();
            } 
        });
    } 
}

/* function to edit task details by team member */
function fun_open_task_details(taskId)
{
   // $("#myModal").modal();
 
     $.ajax({
            type: "POST",
            dataType: "html",
            url: "{{ url('/edit') }}",
            data: {
                'task_id': taskId,
                '_token': "{{ csrf_token() }}",
            },
            success: function(data){
               $(".modal-body").html(data);
            } 
        });
        $("#myModal").modal();
}
</script>