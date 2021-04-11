$(function(){

	var videoQuizList = [
		{
			time: 40,
			answered: false,
			quizList: [
				{
					id: 12,
					question: 'This is first question of first part',
					optionList: [
						{
							id: 1,
							value: "First option"
						},
						{
							id: 2,
							value: "Second option"
						},
						{
							id: 3,
							value: "Third option"
						},
						{
							id: 4,
							value: "Forth option"
						}
					],
					answer: 1,
					usersAnswer: null
				},
				{
					id: 1,
					question: 'This is second question of first part',
					optionList: [
						{
							id: 1,
							value: "First option"
						},
						{
							id: 2,
							value: "Second option"
						},
						{
							id: 3,
							value: "Third option"
						},
						{
							id: 4,
							value: "Forth option"
						}
					],
					answer: 2,
					usersAnswer: null
				},
				{
					id: 1,
					question: 'This is third question of first part',
					optionList: [
						{
							id: 1,
							value: "First option"
						},
						{
							id: 2,
							value: "Second option"
						},
						{
							id: 3,
							value: "Third option"
						},
						{
							id: 4,
							value: "Forth option"
						}
					],
					answer: 3,
					usersAnswer: null
				},
				{
					id: 1,
					question: 'This is forth question of first part',
					optionList: [
						{
							id: 1,
							value: "First option"
						},
						{
							id: 2,
							value: "Second option"
						},
						{
							id: 3,
							value: "Third option"
						},
						{
							id: 4,
							value: "Forth option"
						}
					],
					answer: 4,
					usersAnswer: null
				}
			]
		},
		{
			time: 120,
			answered: false,
			quizList: [
				{
					id: 3,
					question: 'This is first question of second part',
					optionList: [
						{
							id: 1,
							value: "First option"
						},
						{
							id: 2,
							value: "Second option"
						},
						{
							id: 3,
							value: "Third option"
						},
						{
							id: 4,
							value: "Forth option"
						}
					],
					answer: 3,
					usersAnswer: null
				},
				{
					id: 4,
					question: 'This is secondo question of second part',
					optionList: [
						{
							id: 1,
							value: "First option"
						},
						{
							id: 2,
							value: "Second option"
						},
						{
							id: 3,
							value: "Third option"
						},
						{
							id: 4,
							value: "Forth option"
						}
					],
					answer: 4,
					usersAnswer: null
				}
			]
		}
	];

	loadPlayerQuestions(videoQuizList);
	setAllowWrongAnswer(false);
	setAllowSkip(false);
	enableQuiz();
	// disableQuiz();

});