<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('submit') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Name" />
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    
                    <div class="d-grid mx-auto">
                        <button type="submit" class="btn btn-dark btn-block">Create Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

