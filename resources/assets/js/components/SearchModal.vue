<template>
    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">Search</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form @submit="submitForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <select class="custom-select" v-model="selected">
                                <option disabled>I want to search for...</option>
                                <option>Jobs</option>
                                <option>Companies</option>
                                <option>Students</option>
                            </select>
                        </div>

                        <hr>

                        <div v-if="selected === 'Jobs'">
                            <div class="form-group">
                                <input type="text" v-model="job.title" class="form-control"
                                       placeholder="Job Title">
                            </div>

                            <div class="form-group">
                                <input type="text" v-model="job.company.name" class="form-control"
                                       placeholder="Company Name">
                            </div>

                            <hr>

                            <p class="form-text text-left">
                                Skills
                                <button type="button" class="btn btn-primary btn-sm" @click="addSkillsRow">
                                    <span class="fa fa-plus"></span>
                                </button>
                            </p>

                            <div class="row">
                                <div class="form-group col-md-6" v-for="skill in job.skills">
                                    <input class="form-control"
                                           type="text"
                                           name="skills[]"
                                           v-model="skill.name">
                                </div>
                            </div>

                        </div>

                        <div v-if="selected === 'Companies'">
                            <div class="form-group">
                                <input type="text" v-model="company.name" class="form-control"
                                       placeholder="Company Name">
                            </div>

                            <div class="form-group">
                                <input type="email" v-model="company.email" class="form-control"
                                       placeholder="Email Address">
                            </div>

                            <div class="form-group">
                                <select class="custom-select" v-model="company.industry">
                                    <option selected disabled value="-1">Select Industry</option>

                                    <option v-for="industry in industries" :value="industry.id">
                                        {{ industry.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div v-if="selected === 'Students'">
                            <div class="form-group">
                                <input type="text" v-model="student.name" class="form-control"
                                       placeholder="Student Name">
                            </div>

                            <div class="form-group">
                                <input type="email" v-model="student.email" class="form-control"
                                       placeholder="Email Address">
                            </div>

                            <div class="form-group">
                                <select class="custom-select" v-model="student.course">
                                    <option selected disabled value="-1">Select Course</option>

                                    <option v-for="course in courses" :value="course.id">
                                        {{ course.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <span class="fe fe-x"></span>
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="fe fe-search"></span>
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import * as axios from "axios";

    export default {
        data() {
            return {
                action: '',
                selected: "I want to search for...",
                company: {
                    name: '',
                    email: '',
                    industry: -1
                },
                student: {
                    name: '',
                    email: '',
                    course: -1,
                },
                job: {
                    company: {
                        name: ''
                    },
                    title: '',
                    skills: [
                        {
                            name: ''
                        }
                    ],
                },
                industries: [],
                courses: []
            }
        },
        mounted() {
            axios.get('/api/industries').then(res => this.industries = res.data);
            axios.get('/api/courses').then(res => this.courses = res.data);
        },
        methods: {
            submitForm(event) {
                event.preventDefault();

                let url = null;

                if (this.selected === 'Jobs') {
                    url = '/home/search/jobs';
                    url += `?title=${encodeURI(this.job.title)}`
                        + `&company_name=${encodeURI(this.job.company.name)}`;

                    this.job.skills.forEach(function (skill) {
                        url += `&skills[]=${skill.name}`;
                    });
                }

                if (this.selected === 'Companies') {
                    url = '/home/search/companies';
                    url += `?company_name=${encodeURI(this.company.name)}` +
                        `&email=${encodeURI(this.company.email)}`;

                    if (this.company.industry !== -1) {
                        url += `&industry=${encodeURI(this.company.industry)}`;
                    }
                }

                if (this.selected === 'Students') {
                    url = '/home/search/students';
                    url += `?student_name=${encodeURI(this.student.name)}` +
                        `&email=${encodeURI(this.student.email)}`;

                    if (this.student.course !== -1) {
                        url += `&course=${encodeURI(this.student.course)}`;
                    }
                }

                window.location = url;
            },
            addSkillsRow(event) {
                event.preventDefault();
                this.job.skills.push({name: ''});
            }
        }
    }
</script>

<style scoped>
    .modal {
        color: #495057;
    }
</style>
