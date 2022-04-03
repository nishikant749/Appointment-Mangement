<form action="{{ route('appointment.update', $appointment->id) }}" method="post" enctype="multipart/form-data" onsubmit="return Validate(this);">
  <input type="hidden" name="appointment_id" value="{{$appointment->id}}">
  @csrf
  {{ method_field('PUT') }}
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
            <h5>Update Status</h5>
            <div class="col-md-12">
                      <div class="mb-3">
                        <label for="doctor" class="form-label required">Status</label>
                        <div class="dropdown">
                          <select  id="status" class="form-control required doctor" name="status" required>
                              <option value="completed">Completed</option>
                              <option value="cancelled">Cancelled</option>
                          </select>
                        </div>
                      </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Update</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
      </div>
  </div>
</form>
