@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-lg-10">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Create Report</h3>
                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">Back to Reports</a>
            </div>

            

            <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="type" class="form-label">Report Type</label>
                    <select name="type" id="type" class="form-control">
                        @php($fixedTypes = [
                            'Daily Accomplishment',
                            'Weekly Operations',
                            'Monthly Financial',
                            'Incident / Issue',
                            'Project Progress',
                            'Attendance / Time Log',
                        ])
                        <option value="">-- Select report type --</option>
                        @foreach($fixedTypes as $t)
                            <option value="{{ $t }}" {{ old('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div id="dynamic-sections">
                    <div id="section-daily" class="type-section d-none">
                        <h5 class="mt-3">Basic Info</h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Date</label>
                                <input type="date" name="daily[date]" class="form-control" value="{{ old('daily.date') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Employee Name</label>
                                <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Department</label>
                                <input type="text" name="daily[department]" class="form-control" value="{{ old('daily.department') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Position</label>
                                <input type="text" name="daily[position]" class="form-control" value="{{ old('daily.position') }}">
                            </div>
                        </div>
                        <h5 class="mt-4">Task Details</h5>
                        <div class="row g-3">
                            <div class="col-md-2"><label class="form-label">Activity</label><input type="text" name="daily[task][activity]" class="form-control" value="{{ old('daily.task.activity') }}"></div>
                            <div class="col-md-4"><label class="form-label">Description</label><input type="text" name="daily[task][description]" class="form-control" value="{{ old('daily.task.description') }}"></div>
                            <div class="col-md-2"><label class="form-label">Hours</label><input type="number" step="0.01" name="daily[task][hours]" class="form-control" value="{{ old('daily.task.hours') }}"></div>
                            <div class="col-md-2"><label class="form-label">Output</label><input type="text" name="daily[task][output]" class="form-control" value="{{ old('daily.task.output') }}"></div>
                            <div class="col-md-2"><label class="form-label">Issues</label><input type="text" name="daily[task][issues]" class="form-control" value="{{ old('daily.task.issues') }}"></div>
                        </div>
                        <div class="mt-3">
                            <label class="form-label">Next Plan</label>
                            <input type="text" name="daily[next_plan]" class="form-control" value="{{ old('daily.next_plan') }}">
                        </div>
                        <h5 class="mt-4">Attachment</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="daily[remarks]" class="form-control" value="{{ old('daily.remarks') }}">
                            </div>
                        </div>
                        <h5 class="mt-4">Approval</h5>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Reviewed By</label><input type="text" name="daily[approval][reviewed_by]" class="form-control" value="{{ old('daily.approval.reviewed_by') }}"></div>
                            <div class="col-md-4"><label class="form-label">Status</label><input type="text" name="daily[approval][status]" class="form-control" value="{{ old('daily.approval.status') }}"></div>
                            <div class="col-md-4"><label class="form-label">Comments</label><input type="text" name="daily[approval][comments]" class="form-control" value="{{ old('daily.approval.comments') }}"></div>
                        </div>
                    </div>

                    <div id="section-weekly" class="type-section d-none">
                        <h5 class="mt-3">Basic Info</h5>
                        <div class="row g-3">
                            <div class="col-md-3"><label class="form-label">Week Covered</label><input type="text" name="weekly[basic][week]" class="form-control" value="{{ old('weekly.basic.week') }}"></div>
                            <div class="col-md-3"><label class="form-label">Department</label><input type="text" name="weekly[basic][department]" class="form-control" value="{{ old('weekly.basic.department') }}"></div>
                            <div class="col-md-3"><label class="form-label">Prepared By</label><input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled></div>
                            <div class="col-md-3"><label class="form-label">Position</label><input type="text" name="weekly[basic][position]" class="form-control" value="{{ old('weekly.basic.position') }}"></div>
                        </div>
                        <h5 class="mt-4">Summary</h5>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Accomplishments</label><textarea name="weekly[summary][accomplishments]" class="form-control">{{ old('weekly.summary.accomplishments') }}</textarea></div>
                            <div class="col-md-4"><label class="form-label">Completed Tasks</label><textarea name="weekly[summary][completed]" class="form-control">{{ old('weekly.summary.completed') }}</textarea></div>
                            <div class="col-md-4"><label class="form-label">Ongoing Tasks</label><textarea name="weekly[summary][ongoing]" class="form-control">{{ old('weekly.summary.ongoing') }}</textarea></div>
                        </div>
                        <h5 class="mt-4">Issues</h5>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Challenges</label><textarea name="weekly[issues][challenges]" class="form-control">{{ old('weekly.issues.challenges') }}</textarea></div>
                            <div class="col-md-6"><label class="form-label">Recommendations</label><textarea name="weekly[issues][recommendations]" class="form-control">{{ old('weekly.issues.recommendations') }}</textarea></div>
                        </div>
                        <h5 class="mt-4">Attachments</h5>
                        <div class="mb-3"><label class="form-label">Remarks</label><input type="text" name="weekly[attachments][remarks]" class="form-control" value="{{ old('weekly.attachments.remarks') }}"></div>
                        <h5 class="mt-4">Approval</h5>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Reviewed By</label><input type="text" name="weekly[approval][reviewed_by]" class="form-control" value="{{ old('weekly.approval.reviewed_by') }}"></div>
                            <div class="col-md-4"><label class="form-label">Status</label><input type="text" name="weekly[approval][status]" class="form-control" value="{{ old('weekly.approval.status') }}"></div>
                            <div class="col-md-4"><label class="form-label">Comments</label><input type="text" name="weekly[approval][comments]" class="form-control" value="{{ old('weekly.approval.comments') }}"></div>
                        </div>
                    </div>

                    <div id="section-monthly" class="type-section d-none">
                        <h5 class="mt-3">Basic Info</h5>
                        <div class="row g-3">
                            <div class="col-md-3"><label class="form-label">Month Covered</label><input type="month" name="monthly[basic][month]" class="form-control" value="{{ old('monthly.basic.month') }}"></div>
                            <div class="col-md-3"><label class="form-label">Department</label><input type="text" name="monthly[basic][department]" class="form-control" value="{{ old('monthly.basic.department') }}"></div>
                            <div class="col-md-3"><label class="form-label">Prepared By</label><input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled></div>
                            <div class="col-md-3"><label class="form-label">Position</label><input type="text" name="monthly[basic][position]" class="form-control" value="{{ old('monthly.basic.position') }}"></div>
                        </div>
                        <h5 class="mt-4">Summary</h5>
                        <div class="row g-3">
                            <div class="col-md-3"><label class="form-label">Budget</label><input type="number" step="0.01" name="monthly[summary][budget]" class="form-control" value="{{ old('monthly.summary.budget') }}"></div>
                            <div class="col-md-3"><label class="form-label">Expenditures</label><input type="number" step="0.01" name="monthly[summary][expenditures]" class="form-control" value="{{ old('monthly.summary.expenditures') }}"></div>
                            <div class="col-md-3"><label class="form-label">Balance</label><input type="number" step="0.01" name="monthly[summary][balance]" class="form-control" value="{{ old('monthly.summary.balance') }}"></div>
                            <div class="col-md-3"><label class="form-label">Remarks</label><input type="text" name="monthly[summary][remarks]" class="form-control" value="{{ old('monthly.summary.remarks') }}"></div>
                        </div>
                        <h5 class="mt-4">Breakdown</h5>
                        <div class="row g-3">
                            <div class="col-md-2"><label class="form-label">Date</label><input type="date" name="monthly[breakdown][date]" class="form-control" value="{{ old('monthly.breakdown.date') }}"></div>
                            <div class="col-md-2"><label class="form-label">Category</label><input type="text" name="monthly[breakdown][category]" class="form-control" value="{{ old('monthly.breakdown.category') }}"></div>
                            <div class="col-md-2"><label class="form-label">Description</label><input type="text" name="monthly[breakdown][description]" class="form-control" value="{{ old('monthly.breakdown.description') }}"></div>
                            <div class="col-md-2"><label class="form-label">Amount</label><input type="number" step="0.01" name="monthly[breakdown][amount]" class="form-control" value="{{ old('monthly.breakdown.amount') }}"></div>
                            <div class="col-md-2"><label class="form-label">Payee</label><input type="text" name="monthly[breakdown][payee]" class="form-control" value="{{ old('monthly.breakdown.payee') }}"></div>
                        </div>
                        <div class="mt-3"><label class="form-label">Budget Source</label><input type="text" name="monthly[budget_source]" class="form-control" value="{{ old('monthly.budget_source') }}"></div>
                        <div class="mt-3"><label class="form-label">Expense Category</label><input type="text" name="monthly[expense_category]" class="form-control" value="{{ old('monthly.expense_category') }}"></div>
                        <div class="mt-3"><em>Auto-Generated Chart will be shown after submission.</em></div>
                        <h5 class="mt-4">Attachments</h5>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Receipts</label><input type="text" name="monthly[attachments][receipts]" class="form-control" value="{{ old('monthly.attachments.receipts') }}"></div>
                            <div class="col-md-6"><label class="form-label">Statements</label><input type="text" name="monthly[attachments][statements]" class="form-control" value="{{ old('monthly.attachments.statements') }}"></div>
                        </div>
                        <h5 class="mt-4">Approval</h5>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Reviewed By</label><input type="text" name="monthly[approval][reviewed_by]" class="form-control" value="{{ old('monthly.approval.reviewed_by') }}"></div>
                            <div class="col-md-4"><label class="form-label">Status</label><input type="text" name="monthly[approval][status]" class="form-control" value="{{ old('monthly.approval.status') }}"></div>
                            <div class="col-md-4"><label class="form-label">Comments</label><input type="text" name="monthly[approval][comments]" class="form-control" value="{{ old('monthly.approval.comments') }}"></div>
                        </div>
                    </div>

                    <div id="section-incident" class="type-section d-none">
                        <h5 class="mt-3">Basic Info</h5>
                        <div class="row g-3">
                            <div class="col-md-3"><label class="form-label">Date/Time</label><input type="datetime-local" name="incident[basic][datetime]" class="form-control" value="{{ old('incident.basic.datetime') }}"></div>
                            <div class="col-md-3"><label class="form-label">Reported By</label><input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled></div>
                            <div class="col-md-2"><label class="form-label">Department</label><input type="text" name="incident[basic][department]" class="form-control" value="{{ old('incident.basic.department') }}"></div>
                            <div class="col-md-2"><label class="form-label">Location</label><input type="text" name="incident[basic][location]" class="form-control" value="{{ old('incident.basic.location') }}"></div>
                            <div class="col-md-1"><label class="form-label">Type</label><input type="text" name="incident[basic][type]" class="form-control" value="{{ old('incident.basic.type') }}"></div>
                            <div class="col-md-1"><label class="form-label">Severity</label><input type="text" name="incident[basic][severity]" class="form-control" value="{{ old('incident.basic.severity') }}"></div>
                        </div>
                        <h5 class="mt-4">Details</h5>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Description</label><textarea name="incident[details][description]" class="form-control">{{ old('incident.details.description') }}</textarea></div>
                            <div class="col-md-3"><label class="form-label">Witnesses</label><input type="text" name="incident[details][witnesses]" class="form-control" value="{{ old('incident.details.witnesses') }}"></div>
                            <div class="col-md-3"><label class="form-label">Action Taken</label><input type="text" name="incident[details][action_taken]" class="form-control" value="{{ old('incident.details.action_taken') }}"></div>
                        </div>
                        <div class="row g-3 mt-1">
                            <div class="col-md-3"><label class="form-label">Cause</label><input type="text" name="incident[details][cause]" class="form-control" value="{{ old('incident.details.cause') }}"></div>
                            <div class="col-md-3"><label class="form-label">Impact</label><input type="text" name="incident[details][impact]" class="form-control" value="{{ old('incident.details.impact') }}"></div>
                        </div>
                        <h5 class="mt-4">Corrective</h5>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Actions</label><input type="text" name="incident[corrective][actions]" class="form-control" value="{{ old('incident.corrective.actions') }}"></div>
                            <div class="col-md-4"><label class="form-label">Responsible Person</label><input type="text" name="incident[corrective][responsible]" class="form-control" value="{{ old('incident.corrective.responsible') }}"></div>
                            <div class="col-md-4"><label class="form-label">Target Date</label><input type="date" name="incident[corrective][target_date]" class="form-control" value="{{ old('incident.corrective.target_date') }}"></div>
                        </div>
                        <h5 class="mt-4">Attachments</h5>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Photos</label><input type="text" name="incident[attachments][photos]" class="form-control" value="{{ old('incident.attachments.photos') }}"></div>
                            <div class="col-md-6"><label class="form-label">Documents</label><input type="text" name="incident[attachments][documents]" class="form-control" value="{{ old('incident.attachments.documents') }}"></div>
                        </div>
                        <h5 class="mt-4">Approval</h5>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Reviewed By</label><input type="text" name="incident[approval][reviewed_by]" class="form-control" value="{{ old('incident.approval.reviewed_by') }}"></div>
                            <div class="col-md-4"><label class="form-label">Status</label><input type="text" name="incident[approval][status]" class="form-control" value="{{ old('incident.approval.status') }}"></div>
                            <div class="col-md-4"><label class="form-label">Comments</label><input type="text" name="incident[approval][comments]" class="form-control" value="{{ old('incident.approval.comments') }}"></div>
                        </div>
                        <div class="mt-3"><em>Follow-up Action Log will be available after submission.</em></div>
                    </div>

                    <div id="section-project" class="type-section d-none">
                        <h5 class="mt-3">Basic Info</h5>
                        <div class="row g-3">
                            <div class="col-md-3"><label class="form-label">Project Title</label><input type="text" name="project[basic][title]" class="form-control" value="{{ old('project.basic.title') }}"></div>
                            <div class="col-md-3"><label class="form-label">Reporting Period</label><input type="text" name="project[basic][period]" class="form-control" value="{{ old('project.basic.period') }}"></div>
                            <div class="col-md-3"><label class="form-label">Prepared By</label><input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled></div>
                            <div class="col-md-3"><label class="form-label">Department</label><input type="text" name="project[basic][department]" class="form-control" value="{{ old('project.basic.department') }}"></div>
                        </div>
                        <h5 class="mt-4">Details</h5>
                        <div class="row g-3">
                            <div class="col-md-3"><label class="form-label">Objective</label><input type="text" name="project[details][objective]" class="form-control" value="{{ old('project.details.objective') }}"></div>
                            <div class="col-md-3"><label class="form-label">Dates</label><input type="text" name="project[details][dates]" class="form-control" value="{{ old('project.details.dates') }}"></div>
                            <div class="col-md-3"><label class="form-label">Status</label><input type="text" name="project[details][status]" class="form-control" value="{{ old('project.details.status') }}"></div>
                            <div class="col-md-3"><label class="form-label">Progress</label><input type="text" name="project[details][progress]" class="form-control" value="{{ old('project.details.progress') }}"></div>
                        </div>
                        <h5 class="mt-4">Accomplishments</h5>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Completed</label><textarea name="project[accomplishments][completed]" class="form-control">{{ old('project.accomplishments.completed') }}</textarea></div>
                            <div class="col-md-4"><label class="form-label">Ongoing</label><textarea name="project[accomplishments][ongoing]" class="form-control">{{ old('project.accomplishments.ongoing') }}</textarea></div>
                            <div class="col-md-4"><label class="form-label">Next Plan</label><textarea name="project[accomplishments][next_plan]" class="form-control">{{ old('project.accomplishments.next_plan') }}</textarea></div>
                        </div>
                        <h5 class="mt-4">Issues</h5>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Challenges</label><textarea name="project[issues][challenges]" class="form-control">{{ old('project.issues.challenges') }}</textarea></div>
                            <div class="col-md-4"><label class="form-label">Causes</label><textarea name="project[issues][causes]" class="form-control">{{ old('project.issues.causes') }}</textarea></div>
                            <div class="col-md-4"><label class="form-label">Actions</label><textarea name="project[issues][actions]" class="form-control">{{ old('project.issues.actions') }}</textarea></div>
                        </div>
                        <h5 class="mt-4">Financial</h5>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Budget</label><input type="number" step="0.01" name="project[financial][budget]" class="form-control" value="{{ old('project.financial.budget') }}"></div>
                            <div class="col-md-4"><label class="form-label">Utilized</label><input type="number" step="0.01" name="project[financial][utilized]" class="form-control" value="{{ old('project.financial.utilized') }}"></div>
                            <div class="col-md-4"><label class="form-label">Remaining</label><input type="number" step="0.01" name="project[financial][remaining]" class="form-control" value="{{ old('project.financial.remaining') }}"></div>
                        </div>
                        <h5 class="mt-4">Approval</h5>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Reviewed By</label><input type="text" name="project[approval][reviewed_by]" class="form-control" value="{{ old('project.approval.reviewed_by') }}"></div>
                            <div class="col-md-4"><label class="form-label">Status</label><input type="text" name="project[approval][status]" class="form-control" value="{{ old('project.approval.status') }}"></div>
                            <div class="col-md-4"><label class="form-label">Comments</label><input type="text" name="project[approval][comments]" class="form-control" value="{{ old('project.approval.comments') }}"></div>
                        </div>
                    </div>

                    <div id="section-attendance" class="type-section d-none">
                        <h5 class="mt-3">Time Logs</h5>
                        <div class="row g-3">
                            <div class="col-md-3"><label class="form-label">Date</label><input type="date" name="attendance[date]" class="form-control" value="{{ old('attendance.date') }}"></div>
                            <div class="col-md-3"><label class="form-label">Department</label><input type="text" name="attendance[department]" class="form-control" value="{{ old('attendance.department') }}"></div>
                            <div class="col-md-3"><label class="form-label">Time In</label><input type="time" name="attendance[time_in_1]" class="form-control" value="{{ old('attendance.time_in_1') }}"></div>
                            <div class="col-md-3"><label class="form-label">Time Out</label><input type="time" name="attendance[time_out_1]" class="form-control" value="{{ old('attendance.time_out_1') }}"></div>
                        </div>
                        <div class="row g-3 mt-1">
                            <div class="col-md-3"><label class="form-label">Time In 2</label><input type="time" name="attendance[time_in_2]" class="form-control" value="{{ old('attendance.time_in_2') }}"></div>
                            <div class="col-md-3"><label class="form-label">Time Out 2</label><input type="time" name="attendance[time_out_2]" class="form-control" value="{{ old('attendance.time_out_2') }}"></div>
                            <div class="col-md-3"><label class="form-label">Total Hours</label><input type="text" class="form-control" value="Calculated on submit" disabled></div>
                        </div>
                        <h5 class="mt-4">Approval</h5>
                        <div class="row g-3">
                            <div class="col-md-4"><label class="form-label">Reviewed By</label><input type="text" name="attendance[approval][reviewed_by]" class="form-control" value="{{ old('attendance.approval.reviewed_by') }}"></div>
                            <div class="col-md-4"><label class="form-label">Status</label><input type="text" name="attendance[approval][status]" class="form-control" value="{{ old('attendance.approval.status') }}"></div>
                            <div class="col-md-4"><label class="form-label">Comments</label><input type="text" name="attendance[approval][comments]" class="form-control" value="{{ old('attendance.approval.comments') }}"></div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="file" class="form-label">Attachment (optional)</label>
                    <input type="file" name="file" id="file" class="form-control">
                    <div class="form-text">Allowed: pdf, xlsx, xls, jpeg, png (max 10MB)</div>
                    @error('file')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary">Reset</button>
                    <button type="submit" name="action" value="draft" class="btn btn-outline-primary">Save Draft</button>
                    <button type="submit" name="action" value="submit" class="btn btn-primary">Submit Report</button>
                </div>
            </form>
        </div>
    </div>
 </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const sections = {
        'Daily Accomplishment': 'section-daily',
        'Weekly Operations': 'section-weekly',
        'Monthly Financial': 'section-monthly',
        'Incident / Issue': 'section-incident',
        'Project Progress': 'section-project',
        'Attendance / Time Log': 'section-attendance',
    };
    function render() {
        document.querySelectorAll('.type-section').forEach(el => el.classList.add('d-none'));
        const val = typeSelect.value;
        if (sections[val]) {
            document.getElementById(sections[val]).classList.remove('d-none');
        }
    }
    typeSelect.addEventListener('change', render);
    render();
});
</script>
@endsection


