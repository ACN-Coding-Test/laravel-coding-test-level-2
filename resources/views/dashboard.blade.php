
      @include('sidebar')
      <!-- partial -->
      
      @include('navbar')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">

            <?php 
                      
              if(count($projects)>0)
              {
                foreach($projects as $data)
                {
                  
              ?>
                <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                    <div class="card-body">
                        <div class="row">
                          <div class="col-9">
                            <a href="{{ url('/projectDetails')}}/{{ $data->id }}">
                              <div class="d-flex align-items-center align-self-start">
                              <h3 class="mb-0">{{ $data->name }}</h3>
                              </div>
                           </a>
                          </div>
                          @isset( $logged_in_user)
                          <!-- condition to show create new project button to Admin and Product owner only --> 
                            @if( $logged_in_user->user_type == 1)
                              <div class="col-3">
                                  <div class="icon icon-box-success "> 
                                  <span class="mdi mdi-playlist-plus icon-item" title="Create new task" onclick="showMyTaskPopup({{ $data->id }})"></span>
                                  </div>                
                              </div>
                              @endif
                          @endif
                        </div>
                    </div>
                  </div>
                </div>
                

                <?php 
                          } 
                        }
                        ?>
          
            </div>
            <div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="color:black">List of Projects</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> Project </th>
                            <th> Start Date </th>
                            <th> Status </th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 
                      
                        if(count($projects)>0)
                        {
                          foreach($projects as $data)
                          {
                            
                        ?>
                            
                                <tr>
                                    <td> {{ $data->name }} </td>
                                    <td> 04 Dec 2019 </td>
                                    <td>
                                    <div class="badge badge-outline-success">Approved</div>
                                    </td>
                                </tr>
                           <?php 
                          } 
                        }
                        ?>
                      
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © harshada.com 2023</span>
              
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    
  </body>
</html>
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
      <div class="modal-body" id="project_form">
          @include('create_project_form')
      </div>
      <div class="modal-body" id="task_form">
      @include('create_task_form')
      </div>
    </div>
  </div>
</div>


<script>
function showMyTaskPopup(projectId){
  
  if(typeof projectId == "undefined")
  {
    $("#task_form").hide();
    $("#project_form").show();
    $(".modal-title").html("Create New Project");
  } else {
    $("#task_form").show();
    $("#project_form").hide();
    $(".modal-title").html("Create New Task");
  }
  $("#myModal").modal();
}
  </script>


       
      <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true
            });

            $('.select2-user').select2({
                placeholder: "Select",
                allowClear: true
            });

        });

    </script>
                    