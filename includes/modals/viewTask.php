<div class="modal fade" id="viewTaskModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered task-modal">
    <div class="modal-content p-4">
      <div class="modal-header pt-0 d-block">
        <div class="d-flex align-items-center">
          <div class="col-10">
            <p class="title-1 mb-1 text-wrap" id="viewTaskTitle">Task Title</p>
          </div>
          <div class="col-2 d-flex justify-content-end">
            <button class="button-fill ms-auto " data-bs-target="#editTaskModal" data-bs-toggle="modal" id="editTaskModalBtn">
              <i class="bi-pencil-square me-2"></i>Edit
            </button>
          </div>
        </div>
        <p class="text-1" id="creatorText">
          Created by Shaoren on Tuesday, 4 June 2024 at 9:30 p.m.
        </p>
      </div>
      <div class="modal-body">
        <p class="title-2">Description</p>
        <p class="text-1 mb-4" id="viewTaskDesc">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
          lobortis eros ipsum, vitae porta ante volutpat quis. Sed aliquet
          lectus eget quam elementum, ut hendrerit lorem rhoncus.
        </p>
        <p class="title-2">Due On</p>
        <p class="text-1 mb-4">Tuesday, 4 June 2024 at 9:30 p.m.</p>
        <p class="title-2">Assigned Members</p>
        <div class="d-flex" id="membersAssigned">
          <span class="members-badge">Sean</span>
        </div>
      </div>
    </div>
  </div>
</div>