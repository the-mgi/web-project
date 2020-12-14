const con = document.getElementById('con');
const mainContainer = document.createElement('div');
mainContainer.className = 'main-container';
const randomColor = () => '#' + Math.random().toString(16).substr(-6);

const a = {
    writtenBy: 'Tara Haelle Medium',
    writtenDate: new Date('8-17-20'),
    heading: 'Your ‘Surge Capacity’ Is Depleted — It’s Why You Feel Awful',
    description: 'Here’s how to pull yourself out of despair and live your life',
    content: '<p>It was the end of the world as we knew it, and I felt fine. That’s almost exactly what I told my psychiatrist at my March 16 appointment, a few days after our children’s school district extended spring break because of the coronavirus. I said the same at my April 27 appointment, several weeks after our state’s stay-at-home order.</p>' +
        '<p>Yes, it was exhausting having a kindergartener and fourth grader doing impromptu distance learning while I was barely keeping up with work. And it was frustrating to be stuck home nonstop, scrambling to get in grocery delivery orders before slots filled up, and tracking down toilet paper. But I was still doing well because I thrive in high-stress emergency situations. It’s exhilarating for my ADHD brain. As just one example, when my husband and I were stranded in Peru during an 8.0-magnitude earthquake that killed thousands, we walked around with a first aid kit helping who we could and tracking down water and food. Then I went out with my camera to document the devastation as a photojournalist and interview Peruvians in my broken Spanish for my hometown paper.</p> <p>Now we were in a pandemic, and I’m a science journalist who has written about infectious disease and medical research for nearly a decade. I was on fire, cranking out stories, explaining epidemiological concepts in my social networks, trying to help everyone around me make sense of the frightening circumstances of a pandemic and the anxiety surrounding the virus.</p> <p>I knew it wouldn’t last. It never does. But even knowing I would eventually crash, I didn’t appreciate how hard the crash would be, or how long it would last, or how hard it would be to try to get back up over and over again, or what getting up even looked like.</p> <p>In those early months, I, along with most of the rest of the country, was using <mark>“surge capacity” to operate, as Ann Masten, PhD, a psychologist and professor of child development at the University of Minnesota, calls it. Surge capacity is a collection of adaptive systems — mental and physical — that humans draw on for short-term survival in acutely stressful situations, such as natural disasters.</mark> But natural disasters occur over a short period, even if recovery is long. Pandemics are different — the disaster itself stretches out indefinitely.</p> <p>“The pandemic has demonstrated both what we can do with surge capacity and the limits of surge capacity,” says Masten. When it’s depleted, it has to be renewed. But what happens when you struggle to renew it because the emergency phase has now become chronic?</p> <p>By my May 26 psychiatrist appointment, I wasn’t doing so hot. I couldn’t get any work done. I’d grown sick of Zoom meetups. It was exhausting and impossible to think with the kids around all day. I felt trapped in a home that felt as much a prison as a haven. I tried to conjure the motivation to check email, outline a story, or review interview notes, but I couldn’t focus. I couldn’t make myself do anything — work, housework, exercise, play with the kids — for that whole week.</p> <p>I know depression, but this wasn’t quite that. It was, as I’d soon describe in an emotional post in a social media group of professional colleagues, an “anxiety-tainted depression mixed with ennui that I can’t kick,” along with a complete inability to concentrate. I spoke with my therapist, tweaked medication dosages, went outside daily for fresh air and sunlight, tried to force myself to do some physical activity, and even gave myself permission to mope for a few weeks. We were in a pandemic, after all, and I had already accepted in March that life would not be “normal” for at least a year or two. But I still couldn’t work, couldn’t focus, hadn’t adjusted. Shouldn’t I be used to this by now?</p> <p>“Why do you think you should be used to this by now? We’re all beginners at this,” Masten told me. “This is a once in a lifetime experience. It’s expecting a lot to think we’d be managing this really well.”</p> <p>It wasn’t until my social media post elicited similar responses from dozens of high-achieving, competent, impressive women I professionally admire that I realized I wasn’t in the minority. My experience was a universal and deeply human one.</p>',
    numberOfTimesRead: 200,
    minRead: 13,
    isBookmarked: true,
    id: 'zyx01'
}

mainContainer.innerHTML = `<div class="main-container">
    <div class="need">
        <div class="popup" id="bookmarkStatus"></div>
    </div>
    <div class="date-data">
        <p class="add-margin">
            <span>&#128339;</span>
            Reads:
            <span id="numberOfTimesRead">${a.numberOfTimesRead}</span>
        </p>
        <p class="add-margin">
            <span>&#128214;</span>
            <span id="minRead">${a.minRead}</span>
            mins read
        </p>
        <p class="add-margin" id="writtenDate">${a.writtenDate.toDateString()}</p>
        <img
            role="button"
            id="bookmarkIcon"
            alt="bookmark-icon"
            style="width: 20px; opacity: .7;"
        >
    </div>
    <div class="heading-desc">
        <h1 id="heading">${a.heading}</h1>
    </div>
    <div class="name-date" style="margin-top: 20px;">
        <div class="name">
            <h4>by: </h4>
            <div class="app-profile-title" style="background-color: ${randomColor()}">
                <p id="firstLetter">${a.writtenBy.substring(0, 1)}</p>
            </div>
            <h4 id="writtenBy">${a.writtenBy}</h4>
        </div>
        <div class="content" style="margin-top: 20px;">
            <h2 id="description" style="opacity: .7"></h2>
            <p id="content">${a.content}</p>
        </div>
    </div>
</div>`
con.append(mainContainer);
document.getElementById(`bookmarkIcon`).src = a.isBookmarked ? '../assets/svgs/bookmarkFilled.svg' : '../assets/svgs/bookmark.svg';
//
// const numberOfTimesRead = document.getElementById('numberOfTimesRead');
// const minRead = document.getElementById('minRead');
// const bookmarkIcon = document.getElementById('bookmarkIcon');
// const heading = document.getElementById('heading');
// const firstLetter = document.getElementById('firstLetter');
