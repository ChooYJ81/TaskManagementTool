<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 500px">
    <div class="modal-content p-3">
      <div class="modal-body">
        <div class="d-flex align-items-center">
          <p class="title-1 m-0">Create a New Task</p>
        </div>
        <p class="text-1 mb-4">
          Fill in the details below to create a new task.
        </p>

        <form id="createTaskForm" class="row">
          <div class="col-12 mb-3">
            <label class="form-label">Task Name</label>
            <input class="form-control" type="text" name="taskName" placeholder="Enter Task Name" required />
          </div>

          <div class="custom-dropdown col-12 mb-3 d-flex flex-column">
            <label class="form-label">Assign Members</label>
            <div class="dropdown-display form-select w-100" id="dropdownDisplay" tabindex="0">Select Members</div>
            <div class="dropdown-options w-100 mt-2" id="dropdownOptions">
              <!-- <label class="dropdown-option"><input type="checkbox" name="members[]" value="1" /> Member 1</label> -->
            </div>
          </div>

          <div class="col-6 mb-3">
            <label class="form-label">Task Priority</label>
            <select class="form-select" name="priority" required>
              <option value="" disabled selected>
                Select Task Priority
              </option>
              <option>Low Priority</option>
              <option>Medium Priority</option>
              <option>High Priority</option>
            </select>
          </div>
          <div class="col-6 mb-3">
            <label class="form-label">Due Date</label>
            <input class="form-control" type="datetime-local" name="due" required />
          </div>

          <div class="col mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" rows="5" placeholder="Enter task description" name="taskDesc" required></textarea>
          </div>

          <input type="hidden" id="taskType" name="type" value="<?php echo $workspaceId; ?>" />
          <input type="hidden" id="taskWorkspaceID" name="workspaceID" value="<?php echo $workspaceId; ?>" />

          <div class="w-100 text-center">
            <button type="submit" class="btn btn-primary mt-4 px-5 b-0" style="background-color:var(--blue)" id="addTaskButton">Create</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>