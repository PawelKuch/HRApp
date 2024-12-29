document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.user-tile').forEach(user => {
        let id = user.dataset.userId;
        let pendingLeavesTile = document.querySelector(`.pending_leaves_tile_${id}`);
        let approvedIncomingLeavesTile = document.querySelector(`.approved_incoming_leaves_tile_${id}`);
        let leavesHistoryTile = document.querySelector(`.leaves_history_tile_${id}`);

        let categoryContainer = document.querySelector(`.leaves_category_container_${id}`);
        user.addEventListener('click', function () {
            let tableBody = document.querySelector(`.pending_leaves_${id} #pending_leaves_table_${id} tbody`);
            let tableTitle = document.querySelector(`#pending_leaves_table_${id} .table_title`);
            tableBody.innerHTML = '';
            let leavesContainer = document.querySelector(`.pending_leaves_${id}`);
            if(categoryContainer.classList.contains('hidden')){
                categoryContainer.classList.remove('hidden')
                categoryContainer.classList.add('leaves_category_container');
            }else {
                categoryContainer.classList.add('hidden');
                leavesContainer.classList.add('hidden');
                tableBody.innerHTML = '';
            }


            pendingLeavesTile.addEventListener('click', function (){
                clickHandler(pendingLeavesTile, leavesContainer, tableBody, tableTitle, 'Pending leaves', 'get-pending-leaves-for-user', id);
                approvedIncomingLeavesTile.classList.remove('active_tile');
                leavesHistoryTile.classList.remove('active_tile');
            });

            approvedIncomingLeavesTile.addEventListener('click', function(){
                clickHandler(approvedIncomingLeavesTile, leavesContainer, tableBody, tableTitle, 'Incoming leaves', 'get-approved-incoming-leaves-for-user',  id);
                leavesHistoryTile.classList.remove('active_tile');
                pendingLeavesTile.classList.remove('active_tile');
            });

            leavesHistoryTile.addEventListener('click', function(){
                clickHandler(leavesHistoryTile, leavesContainer, tableBody, tableTitle, 'Leaves history', 'get-leaves-history-for-user', id);
                pendingLeavesTile.classList.remove('active_tile');
                approvedIncomingLeavesTile.classList.remove('active_tile');
            });
            tableBody.innerHTML = '';
        });
    });
});

function getLeaves(url, tableBody, userId ){
    let moveBackLeaveRequestDiv = document.getElementById('move_back_leave_request');
    let moveBackLeaveRequestUrl = moveBackLeaveRequestDiv.dataset.moveBackLeaveUrl;


    let approveLeaveRequestDiv = document.getElementById('approve_leave_request');
    let approveLeaveRequestUrl = approveLeaveRequestDiv.dataset.approveLeaveUrl;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({userId: userId})
    })
        .then(response => response.json())
        .then(data => {
            if(data.length > 0 ){
                data.forEach(request => {

                    let row = document.createElement('tr');
                    tableBody.appendChild(row);

                    let idCell = document.createElement('td');
                    idCell.textContent = request.id;
                    row.appendChild(idCell);

                    const fromDateCell = document.createElement('td');
                    fromDateCell.textContent = dayjs(request.from_date).format('DD-MM-YYYY');
                    row.appendChild(fromDateCell);

                    const toDateCell = document.createElement('td');
                    toDateCell.textContent = dayjs(request.to_date).format('DD-MM-YYYY');
                    row.appendChild(toDateCell);

                    const actionCell = document.createElement('td');
                    if(url === 'get-pending-leaves-for-user'){
                        actionCell.innerHTML = `<a href="${approveLeaveRequestUrl}${request.id}"><i class="bi bi-check-square text-success"></i></a>`;
                    }else if(url === 'get-approved-incoming-leaves-for-user'){
                        actionCell.innerHTML = `<a href="${moveBackLeaveRequestUrl}${request.id}"><i class="bi bi-arrow-left"></i></a>`;
                    }else{
                        actionCell.innerHTML = '-';
                    }
                    row.appendChild(actionCell);

                })
            }
        })
}

function clickHandler(clicked, containerToShowOrHide, tableBody, tableTitle, titleText, urlForControllerMethod, userId){
    if(containerToShowOrHide.classList.contains('hidden')){
        clicked.classList.add('active_tile');
        containerToShowOrHide.classList.remove('hidden');
        containerToShowOrHide.classList.add('pending_leaves');
        tableTitle.innerHTML = titleText;
        tableBody.innerHTML = '';
        getLeaves(urlForControllerMethod, tableBody, userId)
    }else {
        containerToShowOrHide.classList.add('hidden');
        clicked.classList.remove('active_tile');
    }
}
