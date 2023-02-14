

<div class="justify-content-center">
    <div class="card">
        <div class="card-body">
        <form action="{{ route('submitTask') }}" method="POST">
            @csrf
            <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3"><label>Project name <span class="red-mark">*</span></label></div>
                        <div class="col-md-9">
                        <select class="select2-multiple form-control" name="project_id" multiple="multiple"
                            id="select2Multiple" required>
                            @isset($projects)
                            <?php
                            foreach($projects as $data)
                            {
                            ?>
                            <option value="{{ isset($data->id) ? $data->id : '' }}">{{ isset($data->name) ? $data->name : "" }}</option>
                            <?php 
                            }
                            ?>   
                            @endif
                        </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3"><label>Task Status</label></div>
                        <div class="col-md-9">
                            <select name="task_status" class="form-control">
                                <option value="0" selected disabled> Not started </option>
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
                            <input type="text" name="title" class="form-control" placeholder="Enter Title" required />
                            
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3"><label>Description <span class="red-mark">*</span></label></label></div>
                        <div class="col-md-9">
                            <textarea type="text" name="description" class="form-control" placeholder="Enter Description"></textarea>
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

