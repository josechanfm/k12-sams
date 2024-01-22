<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('configs')->insert([
        //     'key' => 'grade_categories',
        //     'value' => '[
        //         {"value":"P1","label":"P1"},
        //         {"value":"P2","label":"P2"},
        //         {"value":"P3","label":"P3"},
        //         {"value":"P4","label":"P4"},
        //         {"value":"P5","label":"P5"},
        //         {"value":"P6","label":"P6"},
        //         {"value":"SC1","label":"SC1"},
        //         {"value":"SC2","label":"SC2"},
        //         {"value":"SC3","label":"SC3"},
        //         {"value":"SG1","label":"SG1"},
        //         {"value":"SG2","label":"SG2"},
        //         {"value":"SG3","label":"SG3"},
        //     ]',
        // ]);
        DB::table('configs')->insert([
            'key'=>'year_terms',
            'value' =>'[{"value":1,"label":"上學期"},{"value":2,"label":"下學期"}]'
        ]);
        DB::table('configs')->insert([
            'key'=>'klass_letters',
            'value'=>'[{"value":"A","label":"A"},{"value":"B","label":"B"},{"value":"C","label":"C"},{"value":"D","label":"D"},{"value":"E","label":"E"},{"value":"F","label":"F"}]'
        ]);
        DB::table('configs')->insert([
            'key'=>'grade_letters',
            'value'=>'[{"value":"A","label":"A"},{"value":"B","label":"B"},{"value":"C","label":"C"},{"value":"D","label":"D"},{"value":"E","label":"E"},{"value":"F","label":"F"}]'
        ]);
        DB::table('configs')->insert([
            'key'=>'grade_levels',
            'value' =>'[{
                "value": 1,
                "label": "K1",
                "initial": "K",
                "level": 1
            }, {
                "value": 2,
                "label": "K2",
                "initial": "K",
                "level": 2
            }, {
                "value": 3,
                "label": "K3",
                "initial": "K",
                "level": 3
            }, {
                "value": 4,
                "label": "P1",
                "initial": "P",
                "level": 1
            }, {
                "value": 5,
                "label": "P2",
                "initial": "P",
                "level": 2
            }, {
                "value": 6,
                "label": "P3",
                "initial": "P",
                "level": 3
            }, {
                "value": 7,
                "label": "P4",
                "initial": "P",
                "level": 4
            }, {
                "value": 8,
                "label": "P5",
                "initial": "P",
                "level": 5
            }, {
                "value": 9,
                "label": "P6",
                "initial": "P",
                "level": 6
            }, {
                "value": 10,
                "label": "SC1",
                "initial": "SC",
                "level": 1
            }, {
                "value": 11,
                "label": "SC2",
                "initial": "SC",
                "level": 2
            }, {
                "value": 12,
                "label": "SC3",
                "initial": "SC",
                "level": 3
            }, {
                "value": 13,
                "label": "SG1",
                "initial": "SG",
                "level": 1
            }, {
                "value": 14,
                "label": "SG2",
                "initial": "SG",
                "level": 2
            }, {
                "value": 15,
                "label": "SG3",
                "initial": "SG",
                "level": 3
            }]'
        ]);
        DB::table('configs')->insert([
            'key' => 'score_template',
            'value' =>'{
                "term": [{
                    "value": "REGULAR",
                    "label": "平時",
                    "term_id": 1,
                    "is_total": 0
                }, {
                    "value": "EXAM",
                    "label": "考試",
                    "term_id": 1,
                    "is_total": 0
                }, {
                    "value": "YEAR",
                    "label": "總分",
                    "term_id": 1,
                    "is_total": 1
                }, {
                    "value": "REGULAR",
                    "label": "平時",
                    "term_id": 2,
                    "is_total": 0
                }, {
                    "value": "EXAM",
                    "label": "考試",
                    "term_id": 2,
                    "is_total": 0
                }, {
                    "value": "YEAR",
                    "label": "總分",
                    "term_id": 2,
                    "is_total": 1
                }, {
                    "value": "FINAL",
                    "label": "學年總分",
                    "term_id": 9,
                    "is_total": 0,
                    "formular": "=T1*.5+T2*.5"
                }],
                "comment": [{
                    "value": "COMMENT",
                    "label": "描述"
                }]
            }'
        ]);
        DB::table('configs')->insert([
            'key'=>'study_streams',
            'value' =>'[{"value":"ALL","label":"全科"},{"value":"ART","label":"文科"},{"value":"SCI","label":"理科"},{"value":"AAS","label":"文理科"}]'
        ]);
        DB::table('configs')->insert([
            'key'=>'subject_types',
            'value' =>'[{"value":"SUB","label":"學科"},{"value":"ATT","label":"生活習慣和態度"},{"value":"RPAL","label":"獎懲遲缺"},{"value":"LES","label":"餘暇活動"},{"value":"OVA","label":"總體評分"}]'
        ]);
        DB::table('configs')->insert([
            'key' => 'student_state',
            'value' => '{"ACT": "Active","RES": "Resigned"}',
        ]);
        DB::table('configs')->insert([
            'key' => 'year_creation',
            'value' => '{ "kgrade":3, "kklass":3, "kgradeDefault":0, "kklassDefault":0, "pgrade":6, "pklass":5, "pgradeDefault":6, "pklassDefault":4, "sgrade":6, "sklass":5, "sgradeDefault":6, "sklassDefault":4 }',
        ]);
        DB::table('configs')->insert([
            'key'=>'habit_columns',
            'value' =>'[{"name":"health_1","label":"衣服鞋襪整齊清潔","short":"整潔"},
                {"name":"health_2","label":"常剪指甲","short":"指甲"},
                {"name":"health_3","label":"懂得使用手帕或紙巾","short":"紙巾"},
                {"name":"health_4","label":"不把手指雜物放進口裡","short":"手指"},
                {"name":"health_5","label":"能把癈物投入癈紙箱內","short":"癈物"},
                {"name":"behaviour_1","label":"守秩序不喧嚷","short":"喧讓"},
                {"name":"behaviour_2","label":"留心聽講","short":"聽講"},
                {"name":"behaviour_3","label":"坐立行走姿勢正確","short":"姿勢"},
                {"name":"behaviour_4","label":"離開座位把物件桌椅整理好","short":"桌椅"},
                {"name":"behaviour_5","label":"愛護公物用後放回原處","short":"公物"},
                {"name":"behaviour_6","label":"遵守校規","short":"校規"},
                {"name":"social_1","label":"守時","short":"守時"},
                {"name":"social_2","label":"尊敬師長,友愛和睦","short":"尊敬"},
                {"name":"social_3","label":"樂於助人","short":"助人"},
                {"name":"social_4","label":"會和別人分享及輪候","short":"分享"},
                {"name":"social_5","label":"誠實坦白肯認錯","short":"誠實"}]'
        ]);
        DB::table('configs')->insert([
            'key'=>'behaviour_genres',
            'value'=>'[{"value":"LATE","label":"遲到"},
                {"value":"ABSENT","label":"缺席"},
                {"value":"DEMERIT","label":"缺點"},
                {"value":"FAULT_BIG","label":"大過"},
                {"value":"FAULT_SMALL","label":"小過"},
                {"value":"CREDIT_BIG","label":"大功"},
                {"value":"CREDIT_SMALL","label":"小功"},
                {"value":"MERIT","label":"優點"}]'
        ]);

        DB::table('configs')->insert([
            'key'=>'score_letters',
            'value'=>'
                [
                    {
                    "letter":"A",
                    "min":90,
                    "max":100
                    },{
                    "letter":"B",
                    "min":80,
                    "max":90
                    },{
                    "letter":"C",
                    "min":70,
                    "max":80
                    },{
                    "letter":"D",
                    "min":60,
                    "max":80
                    },{
                    "letter":"E",
                    "min":50,
                    "max":70
                    },{
                    "letter":"A",
                    "min":40,
                    "max":0
                    }
                ]'
        ]);
        DB::table('configs')->insert([
            'key'=>'certificates',
            'value'=>'[{
                "value": "C1",
                "label": "服務獎",
                "category": null
            }, {
                "value": "C2",
                "label": "風紀服務獎",
                "category": [{
                    "value": "C2-1",
                    "label": "隊長"
                }, {
                    "value": "C2-2",
                    "label": "副隊長"
                }, {
                    "value": "C2-3",
                    "label": "隊員"
                }]
            }, {
                "value": "C3",
                "label": "領袖生服務獎",
                "category": null
            }, {
                "value": "C4",
                "label": "操行獎",
                "category": null
            }, {
                "value": "C5",
                "label": "學業獎",
                "category": [{
                    "value": "C5-1",
                    "label": "壹"
                }, {
                    "value": "C5-2",
                    "label": "貳"
                }, {
                    "value": "C5-3",
                    "label": "叁"
                }, {
                    "value": "C5-4",
                    "label": "肆"
                }, {
                    "value": "C5-5",
                    "label": "伍"
                }]
            }, {
                "value": "C6",
                "label": "循序獎",
                "category": null
            }, {
                "value": "C7",
                "label": "學生自治會服務獎",
                "category": [{
                    "value": "C7-1",
                    "label": "會長"
                }, {
                    "value": "C7-2",
                    "label": "副會長"
                }, {
                    "value": "C7-3",
                    "label": "幹事"
                }]
            }, {
                "value": "C8",
                "label": "飛躍進步獎",
                "category": null
            }]'
        ]);
        DB::table('configs')->insert([
            'key'=>'additive_style',
            'value'=>'"default"',
            'remark'=>'"default","direct","page"'
        ]);

        DB::table('configs')->insert([
            'key'=>'additive_groups',
            'value'=>'[{
                "category": "ATTENDANCE",
                "label": "出勤"
            }, {
                "category": "PERFORM",
                "label": "獎懲"
            }, {
                "category": "COMMENTS",
                "label": "評語"
            }, {
                "category": "VIOLATION",
                "label": "違規"
            }]'
        ]);

        DB::table('configs')->insert([
            'key'=>'topic_abilities',
            'value'=>'[{
                "value":"health",
                "label":"健康與體育"
                },{
                "value":"language",
                "label":"語言"
                },{
                "value":"social",
                "label":"個人、社會與人文"
                },{
                "value":"science",
                "label":"數學與科學"
                },{
                "value":"art",
                "label":"藝術"                
            }]'
        ]);

        DB::table('configs')->insert([
            'key'=>'medical_treatments',
            'value'=>'[{
                "value":"DISCOMFORT",
                "label":"身體不適"
                },{
                "value":"TRAUMA",
                "label":"普通外傷"
                },{
                "value":"REST",
                "label":"卧床休息"
                },{
                "value":"ACCIDENT",
                "label":"嚴重意外"
            }]'
        ]);

    }
}

/*
topic_abilities=
[{
"value":"health",
"label":"健康與體育"
},
{
"value":"language",
"label":"語言"
},
{
"value":"social",
"label":"個人、社會與人文"
},{
"value":"science",
"label":"數學與科學"
},{
"value":"art",
"label":"藝術"
}]
*/