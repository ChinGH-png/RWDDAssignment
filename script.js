let totalCaloriesBurned = 0;
// Error handling to prevent crashes
window.addEventListener('error', function(e) {
    console.log('JavaScript Error caught:', e.error);
    // Don't prevent the default behavior, just log it
});
//yr ass
//black ass
// Safe element selector function
function safeQuerySelector(selector) {
    try {
        const element = document.querySelector(selector);
        return element || null;
    } catch (error) {
        console.log('Element not found:', selector);
        return null;
    }
}
const menuToggle = document.getElementById('menuToggle');
const mainNav = document.getElementById('mainNav');

function toggleMenu() {
    menuToggle.classList.toggle('active');
    mainNav.classList.toggle('active');
}

function hideMenu() {
    menuToggle.classList.remove('active');
    mainNav.classList.remove('active');
}

menuToggle.addEventListener('click', toggleMenu);

// Close menu when clicking outside on mobile only
if (window.innerWidth < 768) {
    document.addEventListener('click', function(event) {
        const isClickInsideNav = mainNav.contains(event.target);
        const isClickOnToggle = menuToggle.contains(event.target);
        if (!isClickInsideNav && !isClickOnToggle && mainNav.classList.contains('active')) {
            hideMenu();
        }
    });
}

// ================== AUTH STATE ==================
let isSignedIn = false;
let userProfile = { name: "John Doe", email: "john@example.com", bio: "Fitness enthusiast." };
let workoutProgress = 0; // Start at 0
let currentWorkoutIndex = 0;
let completedWorkouts = 0; // Track completed workouts

// Sample workout data with unique procedures
const workouts = [
    {
        id: 1,
        title: "Cardio Blast",
        icon: "fas fa-fire",
        duration: 30,
        calories: 350,
        description: "30-minute high intensity cardio workout to burn calories and improve endurance.",
        procedure: [
            "Warm up for 5 minutes with light jogging and dynamic stretches",
            "Jumping jacks - 30 seconds at high intensity",
            "High knees - 30 seconds, focus on form",
            "Burpees - 30 seconds, modify if needed",
            "Rest - 15 seconds between exercises",
            "Repeat circuit 3 times with 1-minute rest between circuits",
            "Cool down with stretches for 5 minutes"
        ]
    },
    {
        id: 2,
        title: "Strength Training",
        icon: "fas fa-dumbbell",
        duration: 45,
        calories: 280,
        description: "Full body strength workout focusing on major muscle groups.",
        procedure: [
            "Warm up with 5 minutes of light cardio",
            "Squats - 3 sets of 12 reps",
            "Push-ups - 3 sets of 10 reps",
            "Dumbbell rows - 3 sets of 12 reps per arm",
            "Lunges - 3 sets of 10 reps per leg",
            "Plank - 3 sets of 30 seconds",
            "Cool down with full body stretches"
        ]
    },
    {
        id: 3,
        title: "Yoga Flow",
        icon: "fas fa-spa",
        duration: 60,
        calories: 180,
        description: "Relaxing yoga session to improve flexibility and reduce stress.",
        procedure: [
            "Begin with 5 minutes of breathing exercises",
            "Sun salutations - 5 rounds",
            "Warrior poses sequence",
            "Balance poses: tree pose and dancer pose",
            "Seated forward bends and twists",
            "Backbends: bridge pose and camel pose",
            "Final relaxation in corpse pose for 5 minutes"
        ]
    },
    {
        id: 4,
        title: "HIIT Workout",
        icon: "fas fa-bolt",
        duration: 25,
        calories: 400,
        description: "High Intensity Interval Training for maximum fat burning.",
        procedure: [
            "Dynamic warm up for 3 minutes",
            "Mountain climbers - 45 seconds work, 15 seconds rest",
            "Jump squats - 45 seconds work, 15 seconds rest",
            "Plank jacks - 45 seconds work, 15 seconds rest",
            "Speed skaters - 45 seconds work, 15 seconds rest",
            "Repeat circuit 4 times",
            "Cool down with light stretching"
        ]
    }
];


// ================== FOOD / RECIPES MODULE ==================

const recipes = [
  // Breakfast (6)
  {
    id: 101,
    title: "Avocado Toast with Poached Egg",
    type: "Breakfast",
    prepTime: 12,
    calories: 380,
    description: "Creamy avocado on toasted sourdough with a runny poached egg and chili flakes.",
    ingredients: [
      "2 slices sourdough bread",
      "1 ripe avocado",
      "1 tsp lemon juice",
      "2 free-range eggs",
      "Pinch sea salt, black pepper",
      "Chili flakes, optional"
    ],
    instructions: [
      "Bring a wide pan of water to a gentle simmer and add a splash of vinegar.",
      "Crack each egg into a small bowl. Stir the water to create a vortex and slide eggs in one at a time. Poach 3–4 minutes for a runny yolk.",
      "Toast sourdough slices until golden and crisp.",
      "Mash avocado with lemon juice, sea salt and pepper. Spread evenly on toast.",
      "Top each toast with a poached egg, sprinkle chili flakes and serve immediately."
    ],
    nutrition: "Protein: 16g | Carbs: 34g | Fat: 20g"
  },
  {
    id: 102,
    title: "Banana Oat Pancakes",
    type: "Breakfast",
    prepTime: 18,
    calories: 360,
    description: "Light, fluffy pancakes made with oats and banana — no refined sugar required.",
    ingredients: [
      "1 ripe banana",
      "2 eggs",
      "1/2 cup rolled oats",
      "1/2 tsp baking powder",
      "1/4 tsp cinnamon",
      "Butter or oil for pan"
    ],
    instructions: [
      "Blend banana, eggs and oats until smooth. Stir in baking powder and cinnamon.",
      "Heat a non-stick pan over medium heat and add a little butter.",
      "Pour 2–3 Tbsp batter per pancake and cook until bubbles form on the surface.",
      "Flip and cook 1–2 minutes more until golden. Serve with yogurt or maple syrup."
    ],
    nutrition: "Protein: 12g | Carbs: 48g | Fat: 10g"
  },
  {
    id: 103,
    title: "Greek Yogurt Parfait",
    type: "Breakfast",
    prepTime: 7,
    calories: 240,
    description: "Layered Greek yogurt with honey, granola and fresh berries for a quick protein-rich breakfast.",
    ingredients: [
      "1 cup Greek yogurt",
      "1/3 cup granola",
      "1/2 cup mixed berries",
      "1 tsp honey",
      "Seeds (chia or flax) optional"
    ],
    instructions: [
      "Spoon half the yogurt into a glass or bowl, add a layer of berries and half the granola.",
      "Repeat layers and drizzle honey on top. Sprinkle seeds if using.",
      "Serve chilled."
    ],
    nutrition: "Protein: 18g | Carbs: 30g | Fat: 6g"
  },
  {
    id: 104,
    title: "Savory Spinach & Feta Omelette",
    type: "Breakfast",
    prepTime: 10,
    calories: 290,
    description: "A quick omelette packed with spinach, tangy feta and herbs.",
    ingredients: [
      "3 eggs",
      "Handful fresh spinach",
      "30g feta cheese, crumbled",
      "1 tbsp olive oil",
      "Salt & pepper, fresh herbs"
    ],
    instructions: [
      "Whisk eggs with a pinch of salt and pepper.",
      "Sauté spinach in olive oil until wilted, set aside.",
      "Pour eggs into a hot non-stick pan, let set slightly then add spinach and feta on one half.",
      "Fold omelette and cook another minute. Slide onto plate and garnish with herbs."
    ],
    nutrition: "Protein: 22g | Carbs: 4g | Fat: 20g"
  },
  {
    id: 105,
    title: "Apple Cinnamon Overnight Oats",
    type: "Breakfast",
    prepTime: 10,
    calories: 310,
    description: "Make ahead oats soaked in milk overnight with apple, cinnamon and walnuts.",
    ingredients: [
      "1/2 cup rolled oats",
      "1/2 cup milk or almond milk",
      "1/2 apple, diced",
      "1 tsp cinnamon",
      "1 tbsp chopped walnuts",
      "1 tsp maple syrup (optional)"
    ],
    instructions: [
      "Combine oats, milk, apple, cinnamon and maple syrup in a jar.",
      "Cover and refrigerate overnight.",
      "In the morning, top with walnuts and an extra splash of milk if needed."
    ],
    nutrition: "Protein: 8g | Carbs: 46g | Fat: 10g"
  },
  {
    id: 106,
    title: "Mango Coconut Smoothie Bowl",
    type: "Breakfast",
    prepTime: 7,
    calories: 330,
    description: "Thick mango smoothie topped with coconut, granola and chia seeds for texture.",
    ingredients: [
      "1 cup frozen mango",
      "1/2 banana",
      "1/2 cup coconut milk",
      "Toppings: granola, shredded coconut, chia seeds"
    ],
    instructions: [
      "Blend mango, banana and coconut milk until thick and smooth.",
      "Pour into bowl and arrange toppings neatly on top.",
      "Serve immediately with a spoon."
    ],
    nutrition: "Protein: 4g | Carbs: 60g | Fat: 8g"
  },

  // Lunch (6)
  {
    id: 201,
    title: "Quinoa & Chickpea Power Bowl",
    type: "Lunch",
    prepTime: 20,
    calories: 460,
    description: "Protein-packed bowl with quinoa, roasted chickpeas, avocado and lemon-tahini dressing.",
    ingredients: [
      "1 cup cooked quinoa",
      "1/2 cup roasted chickpeas",
      "1/2 avocado sliced",
      "Mixed salad leaves",
      "2 tbsp tahini, 1 tbsp lemon juice"
    ],
    instructions: [
      "Prepare quinoa and allow to cool slightly.",
      "Toss roasted chickpeas with olive oil, paprika and a pinch of salt.",
      "Whisk tahini with lemon juice and a little warm water to make dressing.",
      "Layer salad leaves, quinoa, chickpeas and avocado. Drizzle dressing and serve."
    ],
    nutrition: "Protein: 16g | Carbs: 52g | Fat: 20g"
  },
  {
    id: 202,
    title: "Chicken Caesar Wrap",
    type: "Lunch",
    prepTime: 15,
    calories: 520,
    description: "Grilled chicken, crisp romaine and a light Caesar-style dressing wrapped in a tortilla.",
    ingredients: [
      "1 tortilla wrap",
      "100g grilled chicken, sliced",
      "Romaine lettuce, grated parmesan",
      "2 tbsp light Caesar dressing"
    ],
    instructions: [
      "Combine chicken, lettuce, parmesan and dressing in a bowl.",
      "Place mixture on tortilla, fold tightly and slice in half.",
      "Serve with a side of carrot sticks."
    ],
    nutrition: "Protein: 34g | Carbs: 45g | Fat: 18g"
  },
  {
    id: 203,
    title: "Soba Noodle Salad with Sesame",
    type: "Lunch",
    prepTime: 18,
    calories: 400,
    description: "Chilled buckwheat noodles with crisp veggies and a sesame-soy dressing.",
    ingredients: [
      "120g soba noodles",
      "Cucumber, carrot, spring onions",
      "2 tbsp soy sauce, 1 tbsp sesame oil, 1 tsp rice vinegar"
    ],
    instructions: [
      "Cook soba according to package, rinse under cold water to stop cooking.",
      "Julienne veggies and toss with noodles.",
      "Mix soy, sesame oil and vinegar; toss through and sprinkle sesame seeds before serving."
    ],
    nutrition: "Protein: 12g | Carbs: 60g | Fat: 12g"
  },
  {
    id: 204,
    title: "Mediterranean Tuna Salad",
    type: "Lunch",
    prepTime: 12,
    calories: 360,
    description: "Light salad of canned tuna, olives, cucumber, tomatoes and a lemon-olive oil dressing.",
    ingredients: [
      "1 can tuna in water, drained",
      "Cherry tomatoes, cucumber, red onion",
      "Olives, 1 tbsp olive oil, 1 tbsp lemon juice"
    ],
    instructions: [
      "Combine tuna with chopped veggies and olives in a bowl.",
      "Whisk olive oil and lemon juice and toss to coat.",
      "Serve on a bed of greens or with crusty bread."
    ],
    nutrition: "Protein: 28g | Carbs: 10g | Fat: 20g"
  },
  {
    id: 205,
    title: "Veggie Burrito Bowl",
    type: "Lunch",
    prepTime: 20,
    calories: 480,
    description: "Black beans, rice, roasted peppers, corn and salsa come together for a satisfying bowl.",
    ingredients: [
      "1 cup cooked rice",
      "1/2 cup black beans",
      "Roasted peppers, corn, avocado",
      "Salsa and a squeeze of lime"
    ],
    instructions: [
      "Warm rice and beans; assemble in a bowl with roasted veggies and avocado.",
      "Top with salsa and a squeeze of lime. Add fresh coriander if available.",
      "Optional: add a dollop of Greek yogurt."
    ],
    nutrition: "Protein: 14g | Carbs: 70g | Fat: 14g"
  },
  {
    id: 206,
    title: "Egg Fried Rice (Quick)",
    type: "Lunch",
    prepTime: 15,
    calories: 420,
    description: "Leftover rice transformed quickly with eggs, peas and soy for a satisfying lunch.",
    ingredients: [
      "1 cup day-old rice",
      "2 eggs",
      "Frozen peas, spring onion",
      "1 tbsp soy sauce, 1 tsp sesame oil"
    ],
    instructions: [
      "Heat oil in a pan, scramble eggs and remove.",
      "Fry rice with peas, add soy sauce and sesame oil.",
      "Return eggs, mix and finish with chopped spring onions."
    ],
    nutrition: "Protein: 14g | Carbs: 60g | Fat: 12g"
  },

  // Dinner (7)
  {
    id: 301,
    title: "Grilled Salmon & Asparagus",
    type: "Dinner",
    prepTime: 25,
    calories: 500,
    description: "Simple grilled salmon fillet with lemon, garlic and roasted asparagus.",
    ingredients: [
      "2 salmon fillets (150g each)",
      "1 bunch asparagus",
      "1 lemon, 2 cloves garlic, olive oil"
    ],
    instructions: [
      "Preheat grill or oven to 200°C (400°F).",
      "Toss asparagus with olive oil, salt and pepper; roast 10–12 minutes.",
      "Rub salmon with oil, garlic and lemon zest. Grill 4–6 minutes each side until flaky.",
      "Serve salmon on a bed of asparagus with lemon wedges."
    ],
    nutrition: "Protein: 36g | Carbs: 10g | Fat: 28g"
  },
  {
    id: 302,
    title: "Chicken & Vegetable Stir-Fry",
    type: "Dinner",
    prepTime: 22,
    calories: 430,
    description: "Quick stir-fry with colorful veg, garlic, ginger and a light soy glaze.",
    ingredients: [
      "200g chicken breast, sliced",
      "Broccoli, bell pepper, carrot",
      "2 cloves garlic, 1 tsp ginger, soy sauce"
    ],
    instructions: [
      "Slice chicken thinly and marinate briefly in soy and a splash of sesame oil.",
      "Stir-fry chicken until nearly cooked and set aside.",
      "Cook vegetables in a hot wok until tender-crisp, add garlic and ginger.",
      "Return chicken, add sauce, toss and serve with steamed rice."
    ],
    nutrition: "Protein: 34g | Carbs: 28g | Fat: 14g"
  },
  {
    id: 303,
    title: "Beef Bolognese with Wholewheat Spaghetti",
    type: "Dinner",
    prepTime: 40,
    calories: 620,
    description: "Rich tomato & beef ragù slowly simmered and served over wholewheat pasta.",
    ingredients: [
      "300g minced beef",
      "1 onion, 2 cloves garlic, 1 carrot",
      "400g canned tomatoes, herbs, spaghetti"
    ],
    instructions: [
      "Sauté onion, garlic and diced carrot until soft.",
      "Add minced beef and brown thoroughly.",
      "Pour in canned tomatoes, herbs and simmer 20–25 minutes until thick.",
      "Serve over cooked wholewheat spaghetti and top with parmesan."
    ],
    nutrition: "Protein: 36g | Carbs: 62g | Fat: 24g"
  },
  {
    id: 304,
    title: "Creamy Tofu & Vegetable Curry",
    type: "Dinner",
    prepTime: 30,
    calories: 480,
    description: "Coconut-based curry with tofu and mixed vegetables — aromatic and warming.",
    ingredients: [
      "200g firm tofu, cubed",
      "1 can coconut milk, curry paste",
      "Mixed veg: potato, peas, bell pepper"
    ],
    instructions: [
      "Sear tofu until golden and set aside.",
      "Sauté curry paste briefly, add coconut milk and vegetables.",
      "Simmer until veg are tender, return tofu to warm through and serve with rice."
    ],
    nutrition: "Protein: 22g | Carbs: 40g | Fat: 24g"
  },
  {
    id: 305,
    title: "Prawn & Garlic Linguine",
    type: "Dinner",
    prepTime: 20,
    calories: 560,
    description: "Garlicky prawns tossed with linguine, lemon and parsley for a light but indulgent plate.",
    ingredients: [
      "200g linguine",
      "150g prawns, peeled",
      "3 cloves garlic, lemon, parsley, chili flakes"
    ],
    instructions: [
      "Cook linguine until al dente, reserving some pasta water.",
      "Sauté garlic and chili in olive oil, add prawns and cook until pink.",
      "Add pasta, a splash of pasta water and lemon juice; toss with parsley and serve."
    ],
    nutrition: "Protein: 28g | Carbs: 70g | Fat: 12g"
  },
  {
    id: 306,
    title: "Sheet-Pan Lemon Herb Chicken",
    type: "Dinner",
    prepTime: 40,
    calories: 550,
    description: "One-pan roast chicken thighs with potatoes and seasonal vegetables.",
    ingredients: [
      "4 chicken thighs",
      "400g baby potatoes, carrots, onions",
      "Lemon, rosemary, olive oil, garlic"
    ],
    instructions: [
      "Preheat oven to 200°C (400°F). Toss veggies in oil and herbs and spread on a sheet pan.",
      "Nestle seasoned chicken among veg, add lemon wedges and roast 30–35 minutes until cooked through.",
      "Rest 5 minutes before serving."
    ],
    nutrition: "Protein: 38g | Carbs: 40g | Fat: 24g"
  },
  {
    id: 307,
    title: "Mushroom Risotto (Vegetarian)",
    type: "Dinner",
    prepTime: 35,
    calories: 520,
    description: "Creamy arborio rice cooked slowly with mushrooms and white wine.",
    ingredients: [
      "1 cup arborio rice",
      "200g mixed mushrooms",
      "1 small onion, garlic, 100ml white wine, stock"
    ],
    instructions: [
      "Sauté onion and garlic until translucent, add mushrooms and cook until golden.",
      "Stir in arborio rice to toast, deglaze with white wine.",
      "Gradually add warm stock, stirring until creamy and rice is al dente. Finish with parmesan."
    ],
    nutrition: "Protein: 12g | Carbs: 72g | Fat: 16g"
  },

  // Snacks (6)
  {
    id: 401,
    title: "Protein Smoothie (Chocolate Banana)",
    type: "Snacks",
    prepTime: 5,
    calories: 300,
    description: "Post-workout chocolate banana smoothie with protein powder and oats.",
    ingredients: [
      "1 banana",
      "1 scoop chocolate protein powder",
      "1 cup milk or almond milk",
      "1 tbsp oats"
    ],
    instructions: [
      "Blend banana, protein powder, milk and oats until smooth.",
      "Pour into a glass and enjoy immediately as a recovery drink."
    ],
    nutrition: "Protein: 28g | Carbs: 40g | Fat: 6g"
  },
  {
    id: 402,
    title: "Peanut Butter Energy Balls",
    type: "Snacks",
    prepTime: 12,
    calories: 220,
    description: "No-bake snack balls made with oats, peanut butter and honey — perfect for on-the-go.",
    ingredients: [
      "1 cup rolled oats",
      "1/2 cup peanut butter",
      "2 tbsp honey",
      "2 tbsp chia seeds"
    ],
    instructions: [
      "Mix all ingredients in a bowl until combined.",
      "Roll into 1-inch balls and chill for 20–30 minutes to set.",
      "Store in fridge up to 1 week."
    ],
    nutrition: "Protein: 8g | Carbs: 20g | Fat: 12g"
  },
  {
    id: 403,
    title: "Greek Yogurt & Berry Bowl",
    type: "Snacks",
    prepTime: 5,
    calories: 180,
    description: "Simple, refreshing snack of yogurt, honey and mixed berries.",
    ingredients: [
      "1/2 cup Greek yogurt",
      "1/2 cup mixed berries",
      "1 tsp honey, 1 tbsp granola"
    ],
    instructions: [
      "Spoon yogurt into a bowl, top with berries, a drizzle of honey and granola.",
      "Serve chilled."
    ],
    nutrition: "Protein: 11g | Carbs: 22g | Fat: 3g"
  },
  {
    id: 404,
    title: "Crispy Baked Chickpeas",
    type: "Snacks",
    prepTime: 30,
    calories: 160,
    description: "Savory crunchy baked chickpeas seasoned with paprika and garlic powder.",
    ingredients: [
      "1 can chickpeas, drained and dried",
      "1 tbsp olive oil",
      "1 tsp smoked paprika, garlic powder"
    ],
    instructions: [
      "Preheat oven to 200°C (400°F). Toss chickpeas with oil and spices.",
      "Spread on a baking tray and roast 20–30 minutes until crisp, shaking halfway.",
      "Cool slightly and enjoy as a crunchy snack."
    ],
    nutrition: "Protein: 7g | Carbs: 22g | Fat: 5g"
  },
  {
    id: 405,
    title: "Apple Slices with Almond Butter",
    type: "Snacks",
    prepTime: 3,
    calories: 150,
    description: "Simple, balanced snack: crisp apple slices topped with almond butter and a sprinkle of cinnamon.",
    ingredients: [
      "1 apple, sliced",
      "2 tbsp almond butter",
      "Pinch cinnamon"
    ],
    instructions: [
      "Arrange apple slices on a plate, top each with a small spoonful of almond butter and dust with cinnamon.",
      "Serve immediately."
    ],
    nutrition: "Protein: 4g | Carbs: 22g | Fat: 7g"
  },
  {
    id: 406,
    title: "Mini Caprese Skewers",
    type: "Snacks",
    prepTime: 10,
    calories: 120,
    description: "Light and fresh cherry tomato, mozzarella and basil skewers drizzled with balsamic.",
    ingredients: [
      "12 cherry tomatoes",
      "12 mini mozzarella balls",
      "Fresh basil, balsamic glaze"
    ],
    instructions: [
      "Thread tomato, mozzarella and basil onto small skewers.",
      "Drizzle lightly with balsamic glaze and serve chilled."
    ],
    nutrition: "Protein: 6g | Carbs: 4g | Fat: 8g"
  }
];

// Utility: clear node children
function clearElement(el) {
  while (el && el.firstChild) el.removeChild(el.firstChild);
}


// Render recipe cards for the food page with filtering & grouping
function displayRecipes(filter = "All", searchTerm = "") {
  const foodPage = document.getElementById('food');
  if (!foodPage) return;

  // card container in food page
  const container = foodPage.querySelector('.card-grid');
  if (!container) return;

  // Clear existing content
  container.innerHTML = '';
  const categories = ["Breakfast", "Lunch", "Dinner", "Snacks"];
  categories.forEach(category => {
    // Build header for the category
    const header = document.createElement('h3');
    header.textContent = category;
    header.className = 'section-subtitle';
    header.style.color = 'var(--primary-green)';
    header.style.margin = '1.5rem 0 0.5rem 0';
    header.style.textAlign = 'center';
    container.appendChild(header);

    // grid for cards in this category
    const groupGrid = document.createElement('div');
    groupGrid.className = 'card-grid';
    groupGrid.style.gridTemplateColumns = 'repeat(auto-fit, minmax(240px, 1fr))';
    groupGrid.style.gap = '1rem';
    groupGrid.style.marginBottom = '1rem';
    container.appendChild(groupGrid);

    // filter recipes by category and filter value and search term
    const matched = recipes.filter(r => {
      if (r.type !== category) return false;
      if (filter !== "All" && r.type !== filter) return false;
      if (!searchTerm) return true;
      const s = searchTerm.toLowerCase();
      return (
        r.title.toLowerCase().includes(s) ||
        (r.description && r.description.toLowerCase().includes(s)) ||
        (r.ingredients && r.ingredients.join(' ').toLowerCase().includes(s))
      );
    });

    if (matched.length === 0) {
      const emptyMsg = document.createElement('p');
      emptyMsg.textContent = 'No recipes found in this category.';
      emptyMsg.style.textAlign = 'center';
      emptyMsg.style.gridColumn = '1/-1';
      groupGrid.appendChild(emptyMsg);
    } else {
      matched.forEach(recipe => {
        const card = document.createElement('div');
        card.className = 'card';
        card.style.cursor = 'pointer';
        card.dataset.recipeId = recipe.id;

        card.innerHTML = `
          <div class="card-image" aria-hidden="true">${recipe.title}</div>
          <div class="card-content">
            <div class="card-title">${recipe.title}</div>
            <p class="card-desc">${recipe.description}</p>
            <div class="card-meta">
              <span><i class="fas fa-clock"></i> ${recipe.prepTime} min</span>
              <span><i class="fas fa-fire"></i> ${recipe.calories} cal</span>
            </div>
          </div>
        `;

        // Click behaviour: load detail and show page
        card.addEventListener('click', () => {
          const recipeIndex = recipes.findIndex(r => r.id === recipe.id);
          loadFoodDetail(recipeIndex); // your existing function
          showPage('food-detail');
        });

        groupGrid.appendChild(card);
      });
    }
  });
}

// Filter button wiring (buttons inside #food)
function setupFoodFilters() {
  const foodEl = document.getElementById('food');
  if (!foodEl) return;

  const filterBtns = Array.from(foodEl.querySelectorAll('.filter-options .filter-btn'));
  let activeFilter = 'All';

  filterBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      // visual
      filterBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');

      const label = this.textContent.trim();
      activeFilter = label;
      const searchInput = foodEl.querySelector('.search-box');
      const searchTerm = searchInput ? searchInput.value.trim() : '';
      displayRecipes(activeFilter, searchTerm);
    });
  });
}

// Search wiring inside #food (single search box)
function setupFoodSearch() {
  const foodEl = document.getElementById('food');
  if (!foodEl) return;

  const searchInput = foodEl.querySelector('.search-box');
  if (!searchInput) return;

  let debounceTimer = null;
  searchInput.addEventListener('input', function () {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
      const filterBtn = foodEl.querySelector('.filter-options .filter-btn.active');
      const activeFilter = filterBtn ? filterBtn.textContent.trim() : 'All';
      displayRecipes(activeFilter, this.value.trim());
    }, 99999999);
  });
}

// Load recipe details into #food-detail by recipe id
function loadFoodDetailById(id) {
  const recipe = recipes.find(r => r.id === id);
  if (!recipe) return;

  const detailPage = document.getElementById('food-detail');
  if (!detailPage) return;

  // Title & subtitle
  const titleEl = detailPage.querySelector('.section-title') || detailPage.querySelector('h1.section-title');
  if (titleEl) titleEl.textContent = `${recipe.title} Recipe`;

  const subtitle = detailPage.querySelector('.detail-header p');
  if (subtitle) subtitle.textContent = `Meal Type: ${recipe.type} | Prep Time: ${recipe.prepTime} mins | Calories: ${recipe.calories}`;

  // Detail image area - replace inner text
  const detailImage = detailPage.querySelector('.detail-image');
  if (detailImage) {
    detailImage.innerHTML = `
      <div>
        <i class="fas fa-utensils" style="font-size:4rem;margin-bottom:8px;"></i>
        <h3 style="margin:0.2rem 0;">${recipe.title}</h3>
        <p style="opacity:0.9;margin:0;">${recipe.description}</p>
      </div>
    `;
  }

  // Ingredients list
  const ingredientsList = detailPage.querySelector('.ingredients-list');
  if (ingredientsList) {
    ingredientsList.innerHTML = '';
    recipe.ingredients.forEach(ing => {
      const li = document.createElement('li');
      li.textContent = ing;
      ingredientsList.appendChild(li);
    });
  }

  // Instructions (ordered list)
  const instructionsList = detailPage.querySelector('.instructions-list');
  if (instructionsList) {
    instructionsList.innerHTML = '';
    recipe.instructions.forEach((step, idx) => {
      const li = document.createElement('li');
      li.textContent = step;
      // add step number hint for readability
      li.prepend && (li.innerHTML = `<strong>Step ${idx + 1}:</strong> ${li.textContent}`);
      instructionsList.appendChild(li);
    });
  }

  // Nutrition info
  const infoSections = detailPage.querySelectorAll('.info-section');
  // The nutrition paragraph in your template is the last info-section's p
  const nutritionP = detailPage.querySelector('.info-section:last-of-type p');
  if (nutritionP) nutritionP.textContent = recipe.nutrition || '';

  // Scroll to top of detail
  detailPage.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Simple comment posting — appends a new comment block to the comments section
function setupCommentPosting() {
  const detailPage = document.getElementById('food-detail');
  if (!detailPage) return;

  const postBtn = detailPage.querySelector('.post-comment');
  const textArea = detailPage.querySelector('.comment-text');
  const commentsContainer = detailPage.querySelector('.comments-section');

  if (!postBtn || !textArea || !commentsContainer) return;

  postBtn.addEventListener('click', () => {
    const txt = textArea.value.trim();
    if (!txt) {
      alert('Please write a comment before posting.');
      return;
    }

    // Create new comment element (simple client-side only)
    const commentDiv = document.createElement('div');
    commentDiv.className = 'comment';
    const header = document.createElement('div');
    header.className = 'comment-header';

    // Basic username & date (client-only)
    const username = document.createElement('span');
    username.textContent = 'You';
    const dateSpan = document.createElement('span');
    const now = new Date();
    dateSpan.textContent = now.toLocaleDateString();

    header.appendChild(username);
    header.appendChild(dateSpan);

    const p = document.createElement('p');
    p.textContent = txt;

    commentDiv.appendChild(header);
    commentDiv.appendChild(p);

    // Insert before the form-group (so form remains at bottom)
    const formGroup = detailPage.querySelector('.form-group');
    if (formGroup) {
      commentsContainer.insertBefore(commentDiv, formGroup);
    } else {
      commentsContainer.appendChild(commentDiv);
    }

    // clear textarea
    textArea.value = '';
  });
}

// Initialize food module on DOM ready
document.addEventListener('DOMContentLoaded', function () {
  // initial render: All (no search)
  displayRecipes('All', '');

  // wire filters and search
  setupFoodFilters();
  setupFoodSearch();
  setupCommentPosting();
  
  // NEW: Add click events to recipe cards
  setTimeout(function() {
    setupRecipeCardClicks();
  }, 500);
});

// NEW: Add this function to your script.js
function setupRecipeCardClicks() {
    // Add click event to all recipe cards
    const recipeCards = document.querySelectorAll('#food .card, #recipeGrid .card');
    
    console.log('Found', recipeCards.length, 'recipe cards'); // Debug
    
    recipeCards.forEach(card => {
        // Remove any existing click listeners
        const newCard = card.cloneNode(true);
        card.parentNode.replaceChild(newCard, card);
        
        // Add click event to the new card
        newCard.addEventListener('click', function() {
            const recipeId = this.getAttribute('data-recipe-id');
            console.log('Clicked card with recipe ID:', recipeId);
            
            if (recipeId) {
                // Find recipe by ID (recipes have ids like 101, 102, 201, etc.)
                const recipe = recipes.find(r => r.id === parseInt(recipeId));
                if (recipe) {
                    console.log('Loading recipe:', recipe.title);
                    loadFoodDetailById(recipe.id); // Use the ID-based function
                    showPage('food-detail');
                } else {
                    console.error('Recipe not found for ID:', recipeId);
                }
            } else {
                console.error('No data-recipe-id found on card');
            }
        });
    });
}

function handleLogin(email, password) {
    console.log('Login attempt:', email);
    
    if (!email || !password) {
        alert('Please enter both email and password');
        return false;
    }

    // Send login data to PHP backend for verification
    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);

    return fetch('login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log('PHP Login Response:', data);
        
        if (data.includes('SUCCESS::')) {
            // Login successful
            isSignedIn = true;
            
            // Extract user name from response
            const userName = data.split('Welcome ')[1] || 'User';
            userProfile = { 
                name: userName, 
                email: email, 
                bio: "Fitness enthusiast!" 
            };
            
            localStorage.setItem('isSignedIn', 'true');
            localStorage.setItem('userProfile', JSON.stringify(userProfile));
            alert('Login successful! Welcome back, ' + userName + '!');
            updateAuthUI();
            showPage('home');
            return true;
        } else if (data.includes('ERROR::')) {
            // Login failed - show error message
            const errorMessage = data.replace('ERROR::', '');
            console.error('Login failed:', errorMessage);
            alert('Login failed: ' + errorMessage);
            
            // Ensure user stays logged out
            isSignedIn = false;
            localStorage.removeItem('isSignedIn');
            localStorage.removeItem('userProfile');
            updateAuthUI();
            return false;
        } else {
            // Unexpected response
            console.error('Unexpected response:', data);

            
            isSignedIn = false;
            localStorage.removeItem('isSignedIn');
            localStorage.removeItem('userProfile');
            updateAuthUI();
            return false;
        }
    })
    .catch(error => {
        console.error('Login network error:', error);
        alert('Login failed due to network error. Please try again.');
        
        // Ensure user stays logged out on network errors
        isSignedIn = false;
        localStorage.removeItem('isSignedIn');
        localStorage.removeItem('userProfile');
        updateAuthUI();
        return false;
    });
}

function handleSignup(email, password, confirmPassword, name, gender, goal_name) {
    if (password !== confirmPassword) {
        alert('Passwords do not match!');
        return false;
    }
    
    if (!email || !password || !name || !gender || !goal_name) {
        alert('Please fill in all required fields');
        return false;
    }

    // Send data to PHP backend
    const formData = new FormData();
    formData.append('email', email);
    formData.append('password', password);
    formData.append('name', name);
    formData.append('gender', gender);
    formData.append('Goal_Name', goal_name);
    formData.append('confirm_password', confirmPassword);

    fetch('registration.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Server response:', data);
        
        if (data.success) {
            // Registration successful
            isSignedIn = true;
            userProfile = { name: name, email: email, bio: "New fitness enthusiast!" };
            localStorage.setItem('isSignedIn', 'true');
            localStorage.setItem('userProfile', JSON.stringify(userProfile));
            alert('Account created successfully! Welcome to FIT PM!');
            updateAuthUI();
            showPage('home');
        } else {
            // Show error from PHP
            alert('Registration failed: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Registration failed. Please try again.');
    });

    return false; // Prevent default form submission
}

function logout() {
    // Call PHP logout to clear session
    fetch('logout.php')
    .then(response => response.text())
    .then(data => {
        // Clear local storage and state
        isSignedIn = false;
        localStorage.removeItem('isSignedIn');
        localStorage.removeItem('userProfile');
        alert('You have been logged out successfully.');
        updateAuthUI();
        showPage('login');
    })
    .catch(error => {
        console.error('Logout error:', error);
        // Still clear local data even if PHP logout fails
        isSignedIn = false;
        localStorage.removeItem('isSignedIn');
        localStorage.removeItem('userProfile');
        alert('You have been logged out successfully.');
        updateAuthUI();
        showPage('login');
    });
}

// Function to check login status using cookies
function checkLoginStatus() {
    const cookies = document.cookie.split(';');
    let isLoggedIn = false;
    let userData = null;
    
    cookies.forEach(cookie => {
        const [name, value] = cookie.trim().split('=');
        if (name === 'fitpm_login' && value === '1') {
            isLoggedIn = true;
        }
        if (name === 'fitpm_user') {
            try {
                userData = JSON.parse(decodeURIComponent(value));
            } catch (e) {
                console.error('Error parsing user cookie:', e);
            }
        }
    });
    
    return { isLoggedIn, userData };
}
// ================== PAGE NAVIGATION ==================
function showPage(pageId) {
    document.querySelectorAll('.page').forEach(page => page.classList.remove('active'));
    
    if (pageId === 'edit-profile' && !isSignedIn) {
        alert('Please sign in to access this page.');
        pageId = 'login';
    }
    
    document.getElementById(pageId).classList.add('active');

    // Update navigation active states
    document.querySelectorAll('nav a').forEach(link => link.classList.remove('active'));
    if (pageId === 'workout-type' || pageId === 'workout-detail') {
        document.querySelector('.nav-workout')?.classList.add('active');
    } else if (pageId === 'food' || pageId === 'food-detail') {
        document.querySelector('.nav-food')?.classList.add('active');
    } else if (pageId === 'about') {
        document.querySelector('.nav-about')?.classList.add('active');
    }
    
    // Load specific content for detail pages
    if (pageId === 'workout-detail') {
        loadWorkoutDetail(currentWorkoutIndex);
    } else if (pageId === 'food-detail') {
        loadFoodDetail(0); // Default to first recipe
    }
    
    window.scrollTo(0, 0);
    hideMenu();
}

// ================== WORKOUT FUNCTIONS ==================
function loadWorkoutDetail(index) {
    const workout = workouts[index];
    if (!workout) return;
    
    const detailPage = document.getElementById('workout-detail');
    if (!detailPage) return;
    
    // Update workout details
    detailPage.querySelector('.section-title').textContent = workout.title;
    detailPage.querySelector('.detail-header p').textContent = `${workout.duration}-minute ${workout.description}`;
    
    // Update procedure
    const instructionsList = detailPage.querySelector('.instructions-list');
    instructionsList.innerHTML = '';
    workout.procedure.forEach(step => {
        const li = document.createElement('li');
        li.innerHTML = `<strong>${step.split(' - ')[0]}</strong>${step.includes(' - ') ? ' - ' + step.split(' - ')[1] : ''}`;
        instructionsList.appendChild(li);
    });
    
    // Keep progress (don't reset unless user explicitly resets)
    updateProgressBar();
    
    // Hide mark as done button initially
    const markDoneBtn = detailPage.querySelector('.mark-done');
    if (markDoneBtn) {
        markDoneBtn.style.display = workoutProgress >= 100 ? 'block' : 'none';
    }
    
    // Reset timer
    resetTimer();
}

function updateProgressBar() {
    const progressFill = document.querySelector('.progress-fill');
    const progressText = document.querySelector('.progress-section p');
    
    if (progressFill) {
        progressFill.style.width = `${workoutProgress}%`;
    }
    
    if (progressText) {
        progressText.textContent = `${workoutProgress}% completed`;
    }
    
    // Show/hide mark as done button
    const markDoneBtn = document.querySelector('.mark-done');
    if (markDoneBtn) {
        if (workoutProgress >= 100) {
            markDoneBtn.style.display = 'block';
        } else {
            markDoneBtn.style.display = 'none';
        }
    }
}

function completeWorkout() {
    workoutProgress = 100;
    completedWorkouts++;
    updateProgressBar();

    const currentExercise = workouts[currentWorkoutIndex];
    let caloriesBurned = currentExercise.calories || 100; // Use actual calories from workout
    
    // Save workout completion with proper data
    saveWorkoutCompletion(caloriesBurned, 1, currentExercise.title);
    
    setTimeout(() => {
        alert(`Congratulations! Workout completed successfully!`);
        saveCaloriesToDB(caloriesBurned);
        workoutProgress = 0;
        updateProgressBar();
        showPage('home');
        
        // Update calendar display
        if (document.getElementById('calendar').classList.contains('active')) {
            const today = new Date();
            updateCalendar(today.getMonth(), today.getFullYear());
        }
    }, 500);
}

function saveWorkoutCompletion(caloriesBurned, completedWorkouts = 1, workoutType = 'Custom Workout') {
    const today = new Date();
    const workoutRecord = {
        date: today.toISOString().split('T')[0], // YYYY-MM-DD format
        caloriesBurned: caloriesBurned,
        completedWorkouts: completedWorkouts,
        timestamp: today.getTime(),
        workoutType: workoutType
    };
    
    // Get existing workout history
    const workoutHistory = JSON.parse(localStorage.getItem('fitpm_workout_history') || '[]');
    
    // Check if there's already an entry for today
    const todayStr = today.toISOString().split('T')[0];
    const existingEntryIndex = workoutHistory.findIndex(record => record.date === todayStr);
    
    if (existingEntryIndex !== -1) {
        // Update existing entry
        workoutHistory[existingEntryIndex].caloriesBurned += caloriesBurned;
        workoutHistory[existingEntryIndex].completedWorkouts += completedWorkouts;
        if (!workoutHistory[existingEntryIndex].workouts) {
            workoutHistory[existingEntryIndex].workouts = [];
        }
        workoutHistory[existingEntryIndex].workouts.push({
            type: workoutType,
            calories: caloriesBurned,
            timestamp: today.getTime()
        });
    } else {
        // Add new workout record with workouts array
        workoutRecord.workouts = [{
            type: workoutType,
            calories: caloriesBurned,
            timestamp: today.getTime()
        }];
        workoutHistory.push(workoutRecord);
    }
    
    // Save back to localStorage
    localStorage.setItem('fitpm_workout_history', JSON.stringify(workoutHistory));
    
    console.log('Workout saved:', workoutRecord);
}

function getRandomWorkout() {
    const randomIndex = Math.floor(Math.random() * workouts.length);
    currentWorkoutIndex = randomIndex;
    return randomIndex;
}

// ================== FOOD FUNCTIONS ==================
function loadFoodDetail(index) {
    const recipe = recipes[index];
    if (!recipe) {
        console.error('Recipe not found at index:', index);
        return;
    }
    
    const detailPage = document.getElementById('food-detail');
    if (!detailPage) return;
    
    // Update recipe details
    document.getElementById('recipeTitle').textContent = recipe.title;
    document.getElementById('recipeSubtitle').textContent = `${recipe.type} | Prep Time: ${recipe.prepTime} mins | Calories: ${recipe.calories}`;
    
    // Update the MAIN header section with type-specific styling
    const detailHeader = detailPage.querySelector('.detail-header');
    let gradient = 'linear-gradient(135deg, var(--light-green), var(--primary-green))';
    let icon = 'fas fa-utensils';
    
    switch(recipe.type) {
        case 'Breakfast':
            gradient = 'linear-gradient(135deg, #FFD700, #FF8C00)';
            icon = 'fas fa-egg';
            break;
        case 'Lunch':
            gradient = 'linear-gradient(135deg, #32CD32, #228B22)';
            icon = 'fas fa-apple-alt';
            break;
        case 'Dinner':
            gradient = 'linear-gradient(135deg, #4169E1, #000080)';
            icon = 'fas fa-fish';
            break;
        case 'Snacks':
            gradient = 'linear-gradient(135deg, #D2691E, #8B4513)';
            icon = 'fas fa-cookie';
            break;
    }
    
    // Apply styling to the main header
    if (detailHeader) {
        detailHeader.style.background = gradient;
        detailHeader.style.color = 'white';
        detailHeader.style.padding = '2rem 1rem';
        detailHeader.style.borderRadius = '15px';
        detailHeader.style.marginBottom = '2rem';
        detailHeader.style.textAlign = 'center';
        
        // Add icon to the main title
        const titleElement = detailHeader.querySelector('.section-title');
        if (titleElement) {
            titleElement.innerHTML = `<i class="${icon}" style="margin-right: 0.5rem; font-size: 2rem;"></i>${recipe.title}`;
            titleElement.style.color = 'white';
            titleElement.style.marginBottom = '0.5rem';
        }
        
        // Style the subtitle
        const subtitleElement = detailHeader.querySelector('p');
        if (subtitleElement) {
            subtitleElement.style.color = 'rgba(255,255,255,0.9)';
            subtitleElement.style.fontSize = '1.1rem';
            subtitleElement.style.margin = '0';
        }
    }
    
    // Update recipe image area
    const recipeImage = document.getElementById('recipeImage');
    recipeImage.innerHTML = `
        <div style="text-align: center; color: white; padding: 2rem;">
            <i class="${icon}" style="font-size: 4rem; margin-bottom: 1rem;"></i>
            <h3 style="margin: 0.5rem 0; font-size: 1.5rem;">${recipe.title}</h3>
            <p style="opacity: 0.9; margin: 0; font-size: 1rem;">${recipe.description}</p>
        </div>
    `;
    recipeImage.style.background = gradient;
    recipeImage.style.borderRadius = '15px';
    recipeImage.style.boxShadow = 'var(--shadow)';
    
    // SLIGHTLY GRAY BOXES FOR CONTENT SECTIONS (removed white outline)
    const detailInfo = detailPage.querySelector('.detail-info');
    if (detailInfo) {
        detailInfo.style.background = '#f8f9fa'; // Light gray background
        detailInfo.style.padding = '1.5rem';
        detailInfo.style.borderRadius = '15px';
        detailInfo.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
        detailInfo.style.border = 'none'; // Remove any border
    }
    
    // Style all info sections with slightly gray background
    const infoSections = detailPage.querySelectorAll('.info-section');
    infoSections.forEach(section => {
        section.style.background = '#f8f9fa'; // Light gray background
        section.style.padding = '1.5rem';
        section.style.borderRadius = '12px';
        section.style.marginBottom = '1.5rem';
        section.style.border = 'none'; // Remove any border
        section.style.boxShadow = '0 1px 4px rgba(0,0,0,0.05)';
        
        // Style section headings
        const heading = section.querySelector('h3');
        if (heading) {
            heading.style.color = 'var(--primary-green)';
            heading.style.marginBottom = '1rem';
            heading.style.fontSize = '1.3rem';
        }
        
        // Style lists
        const lists = section.querySelectorAll('ul, ol');
        lists.forEach(list => {
            list.style.color = '#333';
            list.style.paddingLeft = '1.5rem';
        });
        
        // Style list items
        const listItems = section.querySelectorAll('li');
        listItems.forEach(li => {
            li.style.color = '#555';
            li.style.marginBottom = '0.5rem';
            li.style.lineHeight = '1.5';
            li.style.fontSize = '1rem';
        });
        
        // Style paragraphs (nutrition info)
        const paragraphs = section.querySelectorAll('p');
        paragraphs.forEach(p => {
            p.style.color = '#555';
            p.style.margin = '0';
            p.style.fontSize = '1rem';
        });
    });
    
    // Update ingredients
    const ingredientsList = document.getElementById('recipeIngredients');
    ingredientsList.innerHTML = '';
    recipe.ingredients.forEach(ingredient => {
        const li = document.createElement('li');
        li.textContent = ingredient;
        li.style.color = '#555';
        ingredientsList.appendChild(li);
    });
    
    // Update instructions
    const instructionsList = document.getElementById('recipeInstructions');
    instructionsList.innerHTML = '';
    recipe.instructions.forEach((instruction, idx) => {
        const li = document.createElement('li');
        li.innerHTML = `<strong style="color: var(--primary-green);">Step ${idx + 1}:</strong> ${instruction}`;
        li.style.color = '#555';
        instructionsList.appendChild(li);
    });
    
    // Update nutrition
    const nutritionElement = document.getElementById('recipeNutrition');
    nutritionElement.textContent = recipe.nutrition;
    nutritionElement.style.color = '#555';
    nutritionElement.style.fontWeight = '500';
    nutritionElement.style.fontSize = '1rem';
}

// ================== SEARCH ==================
function setupSearch() {
    document.querySelectorAll('.search-box').forEach(searchBox => {
        searchBox.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const container = this.closest('.container');
            const cards = container.querySelectorAll('.card');
            cards.forEach(card => {
                const title = card.querySelector('.card-title').textContent.toLowerCase();
                const description = card.querySelector('.card-desc').textContent.toLowerCase();
                card.style.display = (title.includes(searchTerm) || description.includes(searchTerm)) ? 'block' : 'none';
            });
        });
    });
}

// ================== FORMS ==================
function setupForms() {
 document.getElementById('loginForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('loginEmail').value;
        const password = document.getElementById('loginPassword').value;
        
        console.log('Form submitted - calling handleLogin');
        handleLogin(email, password);
    });

    document.getElementById('signupForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get values using the correct IDs from your HTML
    const email = document.getElementById('signupEmail').value;
    const password = document.getElementById('signupPassword').value;
    const confirmPassword = document.getElementById('signupConfirm').value;
    const name = document.getElementById('signupFullName').value;
    const gender = document.getElementById('signupGender').value;
    const goal_name = document.getElementById('signupGoal').value;

    console.log('Form data:', { email, name, gender, goal_name }); // Debug log

    handleSignup(email, password, confirmPassword, name, gender, goal_name);
});

    document.getElementById('editProfileForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('profileName').value;
        const email = document.getElementById('profileEmail').value;
        const bio = document.getElementById('profileBio').value;
        if (!saveProfile(name, email, bio)) alert('Please fill in name and email fields');
    });

    // Edit/Delete buttons in login form
    document.querySelectorAll('#loginForm .btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.textContent.trim();
            const input = this.closest('.form-group').querySelector('input');
            if (action === 'Edit') input.focus();
            else if (action === 'Delete') input.value = '';
        });
    });
}

// ================== TIMER ==================
let timerInterval;
let timerSeconds = 1800;
let isTimerActive = false;

function startTimer() {
    if (timerInterval) return;
    
    isTimerActive = true;
    updateTimerButtons();
    
    timerInterval = setInterval(() => {
        timerSeconds--;
        updateTimerDisplay();
        
        // Update progress based on timer
        if (timerSeconds > 0) {
            const progress = ((1800 - timerSeconds) / 1800) * 100;
            workoutProgress = Math.min(progress, 99); // Cap at 99% until completion
            updateProgressBar();
        }
        
        if (timerSeconds <= 0) {
            clearInterval(timerInterval);
            timerInterval = null;
            isTimerActive = false;
            updateTimerButtons();
            workoutProgress = 100;
            updateProgressBar();
            alert('Workout completed! Great job!');
        }
    }, 1000);
}

function pauseTimer() {
    clearInterval(timerInterval);
    timerInterval = null;
    isTimerActive = false;
    updateTimerButtons();
}

function resetTimer() {
    clearInterval(timerInterval);
    timerInterval = null;
    isTimerActive = false;
    timerSeconds = 1800;
    updateTimerDisplay();
    updateTimerButtons();
    
    // Don't reset progress when timer resets - only reset on completion
}

function updateTimerDisplay() {
    const minutes = Math.floor(timerSeconds / 60);
    const seconds = timerSeconds % 60;
    const timerDisplay = document.querySelector('.timer');
    if (timerDisplay) {
        timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
}

function updateTimerButtons() {
    const startBtn = document.querySelector('.timer-start');
    const pauseBtn = document.querySelector('.timer-pause');
    const resetBtn = document.querySelector('.timer-reset');
    
    // Remove all active states first
    startBtn?.classList.remove('active');
    pauseBtn?.classList.remove('active');
    resetBtn?.classList.remove('active');
    
    // Add active state only to the button that should be disabled
    if (isTimerActive) {
        startBtn?.classList.add('active'); // Gray out start when running
    }
}

// ================== THEME TOGGLE ==================
const themeToggle = document.getElementById('themeToggle');

function setDarkMode(on) {
    if (on) {
        document.body.classList.add('dark-mode');
        themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        localStorage.setItem('darkMode', 'on');
    } else {
        document.body.classList.remove('dark-mode');
        themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        localStorage.setItem('darkMode', 'off');
    }
}

themeToggle.addEventListener('click', function() {
    const isDarkMode = document.body.classList.contains('dark-mode');
    setDarkMode(!isDarkMode);
});

function updateAuthUI() {
    const desktopAuth = document.querySelector('.desktop-auth');
    const mobileAuth = document.querySelector('.mobile-auth');
    const loginButtons = document.querySelectorAll('.btn-login, .btn-signup');
    const logoutButtons = document.querySelectorAll('.btn-logout');

    if (isSignedIn) {
        // Hide login/signup buttons, show logout button
        loginButtons.forEach(btn => btn.style.display = 'none');
        logoutButtons.forEach(btn => btn.style.display = 'flex');
        
        if (desktopAuth) desktopAuth.style.setProperty('display', 'flex', 'important');
        if (mobileAuth) mobileAuth.style.setProperty('display', 'flex', 'important');
    } else {
        // Show login/signup buttons, hide logout button
        loginButtons.forEach(btn => btn.style.display = 'flex');
        logoutButtons.forEach(btn => btn.style.display = 'none');
        
        if (desktopAuth) desktopAuth.style.setProperty('display', 'flex', 'important');
        if (mobileAuth) mobileAuth.style.setProperty('display', 'flex', 'important');
    }
}

// ================== EXTRA BUTTONS ==================
// ================== EXTRA BUTTONS ==================
function setupButtons() {
    // Timer buttons - WITH NULL CHECKS
    const timerStart = document.querySelector('.timer-start');
    const timerPause = document.querySelector('.timer-pause');
    const timerReset = document.querySelector('.timer-reset');
    const markDone = document.querySelector('.mark-done');
    const nextWorkout = document.querySelector('.next-workout');
    const postComment = document.querySelector('.post-comment');

    if (timerStart) {
        timerStart.addEventListener('click', startTimer);
    }

    if (timerPause) {
        timerPause.addEventListener('click', pauseTimer);
    }

    if (timerReset) {
        timerReset.addEventListener('click', function() {
            clearInterval(timerInterval);
            timerInterval = null;
            isTimerActive = false;
            workoutProgress = 0;
            updateProgressBar();

            // Add calories for skipped exercise
            const currentExercise = workouts[currentWorkoutIndex];
            totalCaloriesBurned += currentExercise.calories;

            // Move to next exercise
            currentWorkoutIndex++;
            if (currentWorkoutIndex >= workouts.length) {
                alert(`Workout completed! Total calories burned: ${totalCaloriesBurned}`);
                showPage('home');
            } else {
                loadWorkoutDetail(currentWorkoutIndex);
                resetTimer();
            }
        });
    }

    // Mark as done button
    if (markDone) {
        markDone.addEventListener('click', function() {
            if (confirm('Mark this workout as completed?')) {
                completeWorkout();
            }
        });
    }

    // Next workout button - directs to random workout
    if (nextWorkout) {
        nextWorkout.addEventListener('click', function() {
            const randomIndex = getRandomWorkout();
            currentWorkoutIndex = randomIndex;
            loadWorkoutDetail(randomIndex);
        });
    }

    // Post comment button
    if (postComment) {
        postComment.addEventListener('click', function() {
            const commentText = document.querySelector('.comment-text');
            if (commentText && commentText.value.trim()) {
                alert('Comment posted successfully!');
                commentText.value = '';
            } else {
                alert('Please enter a comment before posting.');
            }
        });
    }


    // Workout card clicks - WITH NULL CHECKS
    // --- Guarded hookup for the "Custom Workout" card in Workout page (if present)
const customWorkoutCard = document.querySelector('.card[data-type="Custom"]');
if (customWorkoutCard) {
  customWorkoutCard.addEventListener('click', () => showPage('custom-workout'));
}

// --- Hook buttons only if the page exists
document.addEventListener('DOMContentLoaded', () => {
  const customPage = document.getElementById('custom-workout');
  if (!customPage) return;

  const addExerciseRowBtn = document.getElementById('addExerciseRowBtn');
  const prefillBtn = document.getElementById('prefillFromSelected');
  const form = document.getElementById('customWorkoutForm');

  if (addExerciseRowBtn) addExerciseRowBtn.addEventListener('click', addExerciseRow);
  if (prefillBtn) prefillBtn.addEventListener('click', prefillFromSelected);
  if (form) {
    form.addEventListener('submit', async function (e) {
      e.preventDefault();
      await saveCustomWorkout(this);
    });
  }

  // Build (or rebuild) the selectable gallery
  buildExerciseGallery();
  // Load lists below
  loadWorkoutPlans();
});

// --- Build a sane gallery list (not using workout.procedure sentences)
const EXERCISES = {
  Cardio: [
    'Jumping Jacks', 'High Knees', 'Burpees', 'Mountain Climbers', 'Sprints',
    'Butt Kickers', 'Skaters', 'Jump Rope'
  ],
  Strength: [
    'Squats', 'Push-ups', 'Deadlifts', 'Bench Press', 'Lunges',
    'Overhead Press', 'Bent-over Row', 'Hip Thrusts'
  ],
  Yoga: [
    'Sun Salutations', 'Warrior II', 'Tree Pose', 'Downward Dog', 'Child’s Pose',
    'Bridge Pose', 'Cat-Cow', 'Pigeon Pose'
  ]
};

function buildExerciseGallery() {
  const gallery = document.getElementById('exerciseGallery');
  if (!gallery) return;
  gallery.innerHTML = '';

  Object.entries(EXERCISES).forEach(([group, list]) => {
    const h3 = document.createElement('h3');
    h3.textContent = `${group} Exercises`;
    gallery.appendChild(h3);

    const grid = document.createElement('div');
    grid.className = 'exercise-gallery';
    gallery.appendChild(grid);

    list.forEach(name => {
      const card = document.createElement('div');
      card.className = 'exercise-card';
      // Optional image: match your naming convention or skip the <img>
      card.innerHTML = `
        <img src="images/${name.toLowerCase().replace(/[^a-z0-9]+/g,'-')}.jpg" alt="${name}" onerror="this.style.display" value="${name}"> Select</label>
      `;
      grid.appendChild(card);
    });
  });
}

// --- Prefill selected exercises into the form rows
document.querySelectorAll('.exercise-card').forEach(card => {
  const exerciseName = card.querySelector('label').textContent.trim();
  const imgPath = EXERCISE_IMAGES[exerciseName] || 'images/default-placeholder.jpg';

  // Create image element
  const img = document.createElement('img');
  img.src = imgPath;
  img.alt = exerciseName;
  img.style.width = '100%';
  img.style.height = '120px';
  img.style.objectFit = 'cover';
  img.style.marginBottom = '8px';

  // Insert image at the top of the card
  card.insertBefore(img, card.firstChild);
});

// --- Add a blank exercise row
function addExerciseRow() {
  const container = document.getElementById('exerciseList');
  if (!container) return;
  const row = document.createElement('div');
  row.className = 'exercise-row';
  row.innerHTML = `
    <input type="text" name="exercise_name[]" placeholder="Exercise Name" required>
    <input type="number" name="duration_seconds[]" placeholder="Duration (sec)" required>
    <button type="button" class="btn" onclick="this.parentElement.remove()">Remove</button>
  `;
  container.appendChild(row);
}

// --- Save: POST to your PHP and handle JSON response
async function saveCustomWorkout(formEl) {
  const msg = document.getElementById('responseMessage');
  if (msg) { msg.textContent = 'Saving...'; msg.style.color = ''; }

  const formData = new FormData(formEl);
  formData.append('email', localStorage.getItem('userEmail') || '');

  try {
    const res = await fetch('save_custom_workout.php', { method: 'POST', body: formData });
    const data = await res.json(); // expect {status:'success', message:'...', data:{...}} or {status:'error', message:'...'}
    if (data.status === 'success') {
      if (msg) { msg.textContent = 'Workout saved successfully!'; msg.style.color = 'green'; }
      formEl.reset();
      const list = document.getElementById('exerciseList');
      if (list) {
        list.innerHTML = `
          <div class="exercise-row">
            <input type="text" name="exercise_name[]" placeholder="Exercise Name" required>
            <input type="number" name="duration_seconds[]" placeholder="Duration (sec)" required>
            <button type="button" class="btn" onclick="this.parentElement.remove()">Remove</button>
          </div>
        `;
      }
      // refresh views
      await loadWorkoutPlans();
    } else {
      if (msg) { msg.textContent = 'Error: ' + (data.message || 'Unknown error'); msg.style.color = 'red'; }
    }
  } catch (err) {
    if (msg) { msg.textContent = 'Network error saving workout.'; msg.style.color = 'red'; }
    console.error(err);
  }
}

function renderWorkoutCards(container, workouts, showOwner = false) {
  if (!workouts.length) {
    container.innerHTML = '<p>No items.</p>';
    return;
  }
  const frag = document.createDocumentFragment();
  workouts.forEach(w => {
    const card = document.createElement('div');
    card.className = 'workout-card';
    card.innerHTML = `
      <h3>${w.workout_name}</h3>
      <p>${w.description || ''}</p>
      <p>Difficulty: ${w.difficulty_level || '-'}</p>
      <p>Duration: ${w.estimated_duration || 0} mins</p>
      <p>Calories: ${w.estimated_calories_burn || 0}</p>
      ${showOwner ? `<p>Created by: ${w.Email || ''}</p>` : ''}
      <div class="card-actions">
        <button class="btn btn-edit" onclick="editWorkout(${w.PlanID})">Edit</button>
        <button class="btn btn-delete" onclick="deleteWorkout(${w.PlanID})">Delete</button>
      </div>
    `;
    frag.appendChild(card);
  });
  container.appendChild(frag);
}

// --- Single edit/delete versions (remove duplicates elsewhere)
function editWorkout(planId) {
  alert('Edit feature coming soon for Plan ID: ' + planId);
}
async function deleteWorkout(planId) {
  if (!confirm('Delete this workout?')) return;
  try {
    const res = await fetch(`delete_workout.php?id=${planId}`, { method: 'GET' });
    const txt = await res.text();
    alert(txt);
    await loadWorkoutPlans();
  } catch (err) {
    alert('Error deleting workout.');
  }
}

    // Food card clicks - WITH NULL CHECKS
    const foodCards = document.querySelectorAll('.card[onclick*="food-detail"]');
    foodCards.forEach((card, index) => {
        card.addEventListener('click', function() {
            loadFoodDetail(index);
        });
    });
}

// ================== CALENDAR WITH WORKOUT TRACKING ==================
function initCalendar() {
    console.log('Initializing calendar...');
    
    const currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    
    // Update calendar with current month
    updateCalendar(currentMonth, currentYear);
    
    // Add event listeners for previous and next month buttons
    const prevBtn = document.getElementById('prev-month');
    const nextBtn = document.getElementById('next-month');
    
    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            updateCalendar(currentMonth, currentYear);
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            updateCalendar(currentMonth, currentYear);
        });
    }
}

function updateCalendar(month, year) {
    console.log('Updating calendar for:', month, year);
    
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 
                        'July', 'August', 'September', 'October', 'November', 'December'];
    
    // Update month and year display
    const currentMonthElement = document.getElementById('current-month');
    if (currentMonthElement) {
        currentMonthElement.textContent = `${monthNames[month]} ${year}`;
    }
    
    // Get the first day of the month
    const firstDay = new Date(year, month, 1).getDay();
    
    // Get the number of days in the month
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    
    // Get the calendar grid
    const calendarGrid = document.querySelector('.calendar-grid');
    if (!calendarGrid) {
        console.error('Calendar grid not found');
        return;
    }
    
    // Clear previous days (but keep the day headers)
    const existingDays = calendarGrid.querySelectorAll('.calendar-day, .empty');
    existingDays.forEach(day => day.remove());
    
    // Add empty cells for days before the first day of the month
    for (let i = 0; i < firstDay; i++) {
        const emptyDay = document.createElement('div');
        emptyDay.className = 'calendar-day empty';
        calendarGrid.appendChild(emptyDay);
    }
    
    // Get workout data
    const workoutData = getWorkoutDataForMonth(month, year);
    
    // Add days of the month
    const today = new Date();
    const isCurrentMonth = today.getMonth() === month && today.getFullYear() === year;
    
    for (let day = 1; day <= daysInMonth; day++) {
        const dayElement = document.createElement('div');
        dayElement.className = 'calendar-day';
        
        // Check if this day has workout data
        const dayData = workoutData.find(d => d.day === day);
        
        if (dayData) {
            dayElement.classList.add('has-workout');
            dayElement.innerHTML = `
                <div class="day-number">${day}</div>
                <div class="workout-stats">
                    <div class="workout-count">
                        <i class="fas fa-dumbbell"></i> ${dayData.completedWorkouts}
                    </div>
                    <div class="calories-count">
                        <i class="fas fa-fire"></i> ${dayData.totalCalories}
                    </div>
                </div>
            `;
        } else {
            dayElement.innerHTML = `<div class="day-number">${day}</div>`;
        }
        
        // Highlight today
        if (isCurrentMonth && today.getDate() === day) {
            dayElement.classList.add('today');
        }
        
        calendarGrid.appendChild(dayElement);
    }
    
    // Update monthly summary
    updateMonthlySummary(month, year, workoutData);
    
    console.log('Calendar updated successfully');
}

function getWorkoutDataForMonth(month, year) {
    const workoutHistory = JSON.parse(localStorage.getItem('fitpm_workout_history') || '[]');
    
    return workoutHistory.filter(workout => {
        const workoutDate = new Date(workout.date);
        return workoutDate.getMonth() === month && 
               workoutDate.getFullYear() === year;
    }).reduce((acc, workout) => {
        const day = new Date(workout.date).getDate();
        const existingDay = acc.find(d => d.day === day);
        
        if (existingDay) {
            existingDay.completedWorkouts += workout.completedWorkouts || 1;
            existingDay.totalCalories += workout.caloriesBurned || 0;
        } else {
            acc.push({
                day: day,
                completedWorkouts: workout.completedWorkouts || 1,
                totalCalories: workout.caloriesBurned || 0
            });
        }
        
        return acc;
    }, []);
}

function updateMonthlySummary(month, year, workoutData) {
    const summaryElement = document.getElementById('monthly-summary');
    if (!summaryElement) return;
    
    const totalWorkouts = workoutData.reduce((sum, day) => sum + day.completedWorkouts, 0);
    const totalCalories = workoutData.reduce((sum, day) => sum + day.totalCalories, 0);
    const workoutDays = workoutData.length;
    
    summaryElement.innerHTML = `
        <h3>Monthly Summary</h3>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-value">${totalWorkouts}</div>
                <div class="summary-label">Total Workouts</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">${totalCalories}</div>
                <div class="summary-label">Calories Burned</div>
            </div>
            <div class="summary-item">
                <div class="summary-value">${workoutDays}</div>
                <div class="summary-label">Active Days</div>
            </div>
        </div>
    `;
}




// Function to save workout completion (call this when a workout is completed)
function saveWorkoutCompletion(caloriesBurned, completedWorkouts = 1) {
    const today = new Date();
    const workoutRecord = {
        date: today.toISOString().split('T')[0], // YYYY-MM-DD format
        caloriesBurned: caloriesBurned,
        completedWorkouts: completedWorkouts,
        timestamp: today.getTime(),
        workoutType: workouts[currentWorkoutIndex]?.title || 'Custom Workout'
    };
    
    // Get existing workout history
    const workoutHistory = JSON.parse(localStorage.getItem('fitpm_workout_history') || '[]');
    
    // Check if there's already an entry for today
    const todayStr = today.toISOString().split('T')[0];
    const existingEntryIndex = workoutHistory.findIndex(record => record.date === todayStr);
    
    if (existingEntryIndex !== -1) {
        // Update existing entry
        workoutHistory[existingEntryIndex].caloriesBurned += caloriesBurned;
        workoutHistory[existingEntryIndex].completedWorkouts += completedWorkouts;
    } else {
        // Add new workout record
        workoutHistory.push(workoutRecord);
    }
    
    // Save back to localStorage
    localStorage.setItem('fitpm_workout_history', JSON.stringify(workoutHistory));
    
    console.log('Workout saved:', workoutRecord);
    
    // Update the monthly summary display immediately
    const currentMonth = today.getMonth();
    const currentYear = today.getFullYear();
    
}

// ================== FOOD FILTERING AND DISPLAY ==================
function setupFoodFilters() {
    const filterBtns = document.querySelectorAll('#food .filter-btn');
    const searchBox = document.getElementById('foodSearch');
    const recipeGrid = document.getElementById('recipeGrid');

    // Load all recipes initially
    displayRecipes('all');

    // Filter button event listeners
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            // Display filtered recipes
            const filter = this.getAttribute('data-filter');
            displayRecipes(filter);
        });
    });

    // Search functionality
    if (searchBox) {
        searchBox.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            filterRecipes(searchTerm);
        });
    }
}

function displayRecipes(filter = 'all') {
    const recipeGrid = document.getElementById('recipeGrid');
    if (!recipeGrid) return;

    let filteredRecipes = recipes;

    if (filter !== 'all') {
        filteredRecipes = recipes.filter(recipe => recipe.type === filter);
    }

    recipeGrid.innerHTML = '';

    filteredRecipes.forEach(recipe => {
        const recipeCard = createRecipeCard(recipe);
        recipeGrid.appendChild(recipeCard);
    });
    
    // Re-attach click events after rendering
    setTimeout(setupRecipeCardClicks, 100);
}

function createRecipeCard(recipe) {
    const card = document.createElement('div');
    card.className = 'card';
    card.setAttribute('data-type', recipe.type);
    card.dataset.recipeId = recipe.id;
    
    // Use the same icon and color logic as the detail page
    let icon = 'fas fa-utensils';
    let gradient = 'linear-gradient(135deg, var(--light-green), var(--primary-green))';
    
    switch(recipe.type) {
        case 'Breakfast':
            icon = 'fas fa-egg';
            gradient = 'linear-gradient(135deg, #FFD700, #FF8C00)';
            break;
        case 'Lunch':
            icon = 'fas fa-apple-alt';
            gradient = 'linear-gradient(135deg, #32CD32, #228B22)';
            break;
        case 'Dinner':
            icon = 'fas fa-fish';
            gradient = 'linear-gradient(135deg, #4169E1, #000080)';
            break;
        case 'Snacks':
            icon = 'fas fa-cookie';
            gradient = 'linear-gradient(135deg, #D2691E, #8B4513)';
            break;
    }

    card.innerHTML = `
        <div class="card-image" style="background: ${gradient}; display: flex; flex-direction: column; align-items: center; justify-content: center; color: white;">
            <i class="${icon}" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
            ${recipe.type}
        </div>
        <div class="card-content">
            <div class="card-title">${recipe.title}</div>
            <p class="card-desc">${recipe.description}</p>
            <div class="card-meta">
                <span><i class="fas fa-clock"></i> ${recipe.prepTime} min</span>
                <span><i class="fas fa-fire"></i> ${recipe.calories} cal</span>
            </div>
        </div>
    `;

    card.addEventListener('click', function() {
        const recipeIndex = recipes.findIndex(r => r.id === recipe.id);
        if (recipeIndex !== -1) {
            loadFoodDetail(recipeIndex);
            showPage('food-detail');
        }
    });

    return card;
}

function filterRecipes(searchTerm) {
    const activeFilter = document.querySelector('#food .filter-btn.active').getAttribute('data-filter');
    let filteredRecipes = recipes;

    // Apply type filter first
    if (activeFilter !== 'all') {
        filteredRecipes = recipes.filter(recipe => recipe.type === activeFilter);
    }

    // Then apply search filter
    if (searchTerm) {
        filteredRecipes = filteredRecipes.filter(recipe => 
            recipe.title.toLowerCase().includes(searchTerm) ||
            recipe.description.toLowerCase().includes(searchTerm) ||
            recipe.ingredients.some(ingredient => ingredient.toLowerCase().includes(searchTerm))
        );
    }

    const recipeGrid = document.getElementById('recipeGrid');
    recipeGrid.innerHTML = '';

    filteredRecipes.forEach(recipe => {
        const recipeCard = createRecipeCard(recipe);
        recipeGrid.appendChild(recipeCard);
    });
}

// ================== UPDATED FOOD DETAIL LOADER ==================
function loadFoodDetail(index) {
    const recipe = recipes[index];
    if (!recipe) {
        console.error('Recipe not found at index:', index);
        return;
    }
    
    const detailPage = document.getElementById('food-detail');
    if (!detailPage) return;
    
    // Update recipe details
    document.getElementById('recipeTitle').textContent = recipe.title;
    document.getElementById('recipeSubtitle').textContent = `${recipe.type} | Prep Time: ${recipe.prepTime} mins | Calories: ${recipe.calories}`;
    
    // Update recipe image with type-specific styling
    const recipeImage = document.getElementById('recipeImage');
    let gradient = 'linear-gradient(135deg, var(--light-green), var(--primary-green))';
    let icon = 'fas fa-utensils';
    
    switch(recipe.type) {
        case 'Breakfast':
            gradient = 'linear-gradient(135deg, #FFD700, #FF8C00)';
            icon = 'fas fa-egg';
            break;
        case 'Lunch':
            gradient = 'linear-gradient(135deg, #32CD32, #228B22)';
            icon = 'fas fa-apple-alt';
            break;
        case 'Dinner':
            gradient = 'linear-gradient(135deg, #4169E1, #000080)';
            icon = 'fas fa-fish';
            break;
        case 'Snacks':
            gradient = 'linear-gradient(135deg, #D2691E, #8B4513)';
            icon = 'fas fa-cookie';
            break;
    }
    
    recipeImage.innerHTML = `
        <div style="text-align: center; color: white; padding: 2rem;">
            <i class="${icon}" style="font-size: 4rem; margin-bottom: 1rem;"></i>
            <h3 style="margin: 0.5rem 0; font-size: 1.5rem;">${recipe.title}</h3>
            <p style="opacity: 0.9; margin: 0; font-size: 1rem;">${recipe.type}</p>
        </div>
    `;
    recipeImage.style.background = gradient;
    recipeImage.style.borderRadius = '15px';
    recipeImage.style.boxShadow = 'var(--shadow)';
    
    // Update ingredients
    const ingredientsList = document.getElementById('recipeIngredients');
    ingredientsList.innerHTML = '';
    recipe.ingredients.forEach(ingredient => {
        const li = document.createElement('li');
        li.textContent = ingredient;
        ingredientsList.appendChild(li);
    });
    
    // Update instructions
    const instructionsList = document.getElementById('recipeInstructions');
    instructionsList.innerHTML = '';
    recipe.instructions.forEach((instruction, idx) => {
        const li = document.createElement('li');
        li.innerHTML = `<strong>Step ${idx + 1}:</strong> ${instruction}`;
        instructionsList.appendChild(li);
    });
    
    // Update nutrition
    document.getElementById('recipeNutrition').textContent = recipe.nutrition;
}

// ================== INIT ==================
document.addEventListener('DOMContentLoaded', function() {
    setDarkMode(localStorage.getItem('darkMode') === 'on');
    setupSearch();
    setupForms();
    setupButtons();
    updateAuthUI();
    updatePageForAuthStatus(); // ADD THIS LINE
    showPage('home');
    
    // Only initialize calendar if user is logged in
    const { isLoggedIn } = checkLoginStatus();
    if (isLoggedIn) {
        initCalendar();
        currentWorkoutIndex = 0;
        loadWorkoutDetail(currentWorkoutIndex);
    }
    
    setupFoodFilters();
});

function renderCurrent(){
    const ex = runnerExercises[runnerIndex];
    if (!ex) { return; }
    exerciseName.textContent = ex.name;
    exerciseDesc.textContent = ex.type === 'rest' ? 'Rest' : 'Perform the exercise';
    exerciseIcon.className = iconForName(ex.name);
    runnerRemaining = getDurationFor(ex);
    runnerTimer.textContent = fmt(runnerRemaining);
    
    // Set the exercise image source
    document.getElementById('exerciseImage').src = `images/${ex.name.toLowerCase().replace(/ /g, '-')}.jpg`; // Adjust path as necessary

    renderList();
}

function saveCaloriesToDB() {
  const email = localStorage.getItem('userEmail'); // Ensure user email is stored
  if (!email) return;

  const formData = new FormData();
  formData.append('email', email);
  formData.append('calories', totalCaloriesBurned);

  fetch('save_daily_calories.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      console.log('Calories saved successfully');
    } else {
      console.error('Failed to save calories:', data.error);
    }
  })
  .catch(error => console.error('Error saving calories:', error));
}
document.getElementById('customWorkoutForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const workoutName = document.getElementById('workoutName').value;
    const workoutDescription = document.getElementById('workoutDescription').value;
    const difficultyLevel = document.getElementById('difficultyLevel').value;
    const isPublic = document.getElementById('isPublic').checked ? 1 : 0;
    
    if (!workoutName) {
        document.getElementById('responseMessage').innerHTML = '<div style="color: #e53935;">Please enter a workout name</div>';
        return;
    }
    
    if (selectedExercises.length === 0) {
        document.getElementById('responseMessage').innerHTML = '<div style="color: #e53935;">Please add at least one exercise to your workout</div>';
        return;
    }

    // Prepare workout data
    const workoutData = {
    workout_name: document.getElementById('workoutName').value,
    description: document.getElementById('workoutDescription').value,
    difficulty_level: document.getElementById('difficultyLevel').value,
    is_public: document.getElementById('isPublic').checked ? 1 : 0,
    exercises: selectedExercises  // Make sure this array has exercises!
};

fetch('save_custom_workout.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify(workoutData)
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        alert('Workout saved successfully!');
        console.log('Workout ID:', data.workout_id);
    } else {
        alert('Error: ' + data.error);
    }
});
});

    // Handle View Custom Workouts Page
    const myWorkoutsDiv = document.getElementById('myWorkouts');
    const publicWorkoutsDiv = document.getElementById('publicWorkouts');

// Placeholder functions for future features
function editWorkout(planId) {
    alert('Edit feature coming soon for Plan ID: ' + planId);
}

function copyWorkout(planId) {
    alert('Copy feature coming soon for Plan ID: ' + planId);
}
function openCustomWorkoutModal() {
    
 const modal = document.getElementById('customWorkoutModal');
  if (!modal) return;
  _cwmPrevFocus = document.activeElement;

  modal.style.display = 'block';
  modal.setAttribute('aria-hidden', 'false');
  document.body.style.overflow = 'hidden';   // prevent background scroll

  // Focus first input
  const firstField = document.getElementById('cwName');
  (firstField || modal).focus();

  // ESC to close
  modal.addEventListener('keydown', cwmTrapKeys);
  // Click overlay to close
  modal.querySelector('.modal__overlay')?.addEventListener('click', closeCustomWorkoutModal);
}

function closeCustomWorkoutModal() {
  const modal = document.getElementById('customWorkoutModal');
  if (!modal) return;

  modal.style.display = 'none';
  modal.setAttribute('aria-hidden', 'true');
  document.body.style.overflow = '';

  modal.removeEventListener('keydown', cwmTrapKeys);
  modal.querySelector('.modal__overlay')?.removeEventListener('click', closeCustomWorkoutModal);

  // restore focus
  _cwmPrevFocus && _cwmPrevFocus.focus();
}

function cwmTrapKeys(e) {
  if (e.key === 'Escape') {
    e.preventDefault();
    closeCustomWorkoutModal();
    return;
  }
  if (e.key === 'Tab') {
    // simple focus trap inside modal
    const focusables = Array.from(document.querySelectorAll('#customWorkoutModal button, #customWorkoutModal [href], #customWorkoutModal input, #customWorkoutModal select, #customWorkoutModal textarea'))
      .filter(el => !el.hasAttribute('disabled'));
    if (focusables.length === 0) return;
    const first = focusables[0], last = focusables[focusables.length - 1];
    if (e.shiftKey && document.activeElement === first) { last.focus(); e.preventDefault(); }
    else if (!e.shiftKey && document.activeElement === last) { first.focus(); e.preventDefault(); }
  }
}

// Attach to Custom Workout card click
document.querySelector('.custom-workout-card').addEventListener('click', openCustomWorkoutModal);
function loadWorkoutCard(workout) {
    document.getElementById('workoutName').textContent = workout.name;
    document.getElementById('workoutDescription').textContent = workout.description;
    document.getElementById('workoutCalories').textContent = `Calories Burned: ${workout.calories} kcal`;
    document.getElementById('workoutDate').textContent = `Created on: ${workout.created_at}`;
}
// Example: Fetch workouts from API or PHP endpoint
async function loadWorkouts() {
    try {
        const response = await fetch('get_custom_workouts.php'); // Replace with your endpoint
        const workouts = await response.json();

        const container = document.querySelector('.cards-container');
        container.innerHTML = ''; // Clear existing cards

        workouts.forEach(workout => {
            const card = document.createElement('div');
            card.className = 'card custom-workout-card';
            card.innerHTML = `
                <div class="card-body">
                    <h3 class="workout-title">${workout.name}</h3>
                    <p class="workout-description">${workout.description}</p>
                    <p class="workout-calories">Calories Burned: ${workout.calories} kcal</p>
                    <p class="workout-date">Created on: ${workout.created_at}</p>
                    <div class="card-actions">
                        <button class="btn btn-secondary" onclick="editWorkout(${workout.id})">Edit</button>
                        <button class="btn btn-danger" onclick="deleteWorkout(${workout.id})">Delete</button>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });
    } catch (error) {
        console.error('Error loading workouts:', error);
    }
}

// Edit workout
function editWorkout(id) {
    window.location.href = `edit_workout.php?id=${id}`;
}

// Delete workout
async function deleteWorkout(id) {
    if (confirm('Are you sure you want to delete this workout?')) {
        try {
            const response = await fetch(`delete_workout.php?id=${id}`, { method: 'GET' });
            const result = await response.text();
            alert(result);
            loadWorkouts(); // Reload cards after deletion
        } catch (error) {
            console.error('Error deleting workout:', error);
        }
    }
}

// Load workouts on page load
document.addEventListener('DOMContentLoaded', loadWorkouts);

function renderWorkouts(workouts) {
    const container = document.getElementById('customWorkoutContainer');
    container.innerHTML = '';
    workouts.forEach(workout => {
        const card = document.createElement('div');
        card.className = 'workout-card';
        card.innerHTML = `
            <h3>${workout.workout_name}</h3>
            <p>${workout.description}</p>
            <p>Duration: ${workout.estimated_duration} mins</p>
            <p>Calories: ${workout.estimated_calories_burn}</p>
        `;
        container.appendChild(card);
    });
}
function addExerciseRow() {
    const container = document.getElementById('exerciseList');
    const row = document.createElement('div');
    row.className = 'exercise-row';
    row.innerHTML = `
        <input type="text" name="exercise_name[]" placeholder="Exercise Name" required>
        <input type="number" name="duration_seconds[]" placeholder="Duration (sec)" required>
        <button type="button" onclick="this.parentElement.remove()">Remove</button>
    `;
    container.appendChild(row);
}

function renderWorkouts(workouts) {
    const container = document.getElementById('customWorkoutContainer');
    container.innerHTML = '';
    workouts.forEach(workout => {
        const card = document.createElement('div');
        card.className = 'workout-card';
        card.innerHTML = `
            <h3>${workout.workout_name}</h3>
            <p>${workout.description}</p>
            <p>Duration: ${workout.estimated_duration} mins | Calories: ${workout.estimated_calories_burn}</p>
            <h4>Exercises:</h4>
            <ul>${workout.exercises.map(ex => `<li>${ex.ExerciseName} - ${ex.DurationSeconds}s</li>`).join('')}</ul>
        `;
        container.appendChild(card);
    });
}


function loadExerciseGallery() {
    const gallery = document.getElementById('exerciseGallery');
    gallery.innerHTML = '';

    // Example: Using workouts array or fetch from DB
    workouts.forEach(workout => {
        workout.procedure.forEach(exercise => {
            const card = document.createElement('div');
            card.className = 'exercise-card';
            const imagePath = `images/${exercise.toLowerCase().replace(/ /g, '-')}.jpg`; // Based on your naming convention
            card.innerHTML = `
                ${imagePath}
                <h3>${exercise}</h3>
                <label><input type="checkbox" value="${exercise}"> Select</label>
            `;
            gallery.appendChild(card);
        });
    });
}
function saveSelectedExercises() {
    const selected = Array.from(document.querySelectorAll('.exercise-card input:checked'))
        .map(input => input.value);
    console.log('Selected Exercises:', selected);
    // Send to backend if needed
}

document.getElementById('prefillFromSelected').addEventListener('click', function () {
  const selected = Array.from(document.querySelectorAll('.exercise-card input:checked')).map(i => i.value);
  if (!selected.length) {
    alert('Please select exercises first.');
    return;
  }
  const container = document.getElementById('exerciseList');
  selected.forEach(name => {
    const row = document.createElement('div');
    row.className = 'exercise-row';
    row.innerHTML = `
      <input type="text" name="exercise_name[]" value="${name}" required>
      <input type="number" name="duration_seconds[]" placeholder="Duration (sec)" required>
      <button type="button" class="btn" onclick="this.parentElement.remove()">Remove</button>
    `;
    container.appendChild(row);
  });
});

// Cancel button logic
document.getElementById('cancelWorkoutBtn').addEventListener('click', function () {
  document.getElementById('customWorkoutForm').reset();
  document.getElementById('exerciseList').innerHTML = `
    <div class="exercise-row">
      <input type="text" name="exercise_name[]" placeholder="Exercise Name" required>
      <input type="number" name="duration_seconds[]" placeholder="Duration (sec)" required>
      <button type="button" class="btn" onclick="this.parentElement.remove()">Remove</button>
    </div>
  `;
  document.getElementById('responseMessage').textContent = '';
});

// Create workout button logic
document.getElementById('createWorkoutBtn').addEventListener('click', function () {
  document.getElementById('customWorkoutForm').dispatchEvent(new Event('submit'));
});

// ================== AUTHENTICATION CHECK ==================
function requireAuth(action = 'access this feature') {
    const { isLoggedIn } = checkLoginStatus();
    
    if (!isLoggedIn) {
        alert(`Please sign in to ${action}`);
        showPage('login');
        return false;
    }
    return true;
}

function showWorkoutTypePage() {
    if (!requireAuth('browse workouts')) return;
    showPage('workout-type');
}

function showFoodPage() {
    if (!requireAuth('browse recipes')) return;
    showPage('food');
}

function showCalendarPage() {
    if (!requireAuth('view your calendar')) return;
    showPage('calendar');
    initCalendar();
}

function updatePageForAuthStatus() {
    const { isLoggedIn } = checkLoginStatus();
    if (isLoggedIn) {
        document.body.classList.add('logged-in');
    } else {
        document.body.classList.remove('logged-in');
    }
}
// Your existing exercise pools (from your code)
const cardioPool = [
    "Jumping Jacks", "High Knees", "Burpees", "Mountain Climbers", "Sprints",
    "Butt Kickers", "Skaters", "Jump Rope", "Tuck Jumps", "Lateral Hops",
    "Jump Lunges", "Speed Skaters", "Box Jumps", "Stair Runs", "Power Knees"
];

const strengthPool = [
    "Squats", "Push-ups", "Deadlifts", "Bench Press", "Lunges",
    "Overhead Press", "Bent-over Row", "Biceps Curls", "Tricep Dips", "Romanian Deadlift",
    "Chest Fly", "Calf Raises", "Hip Thrusts", "Farmer Carry", "Pull-ups"
];

const yogaPool = [
    "Sun Salutations", "Warrior II", "Tree Pose", "Downward Dog", "Child's Pose",
    "Bridge Pose", "Camel Pose", "Seated Twist", "Standing Forward Bend", "Cat-Cow",
    "Pigeon Pose", "Boat Pose", "Chair Pose", "Eagle Pose", "Reclining Bound Angle"
];

// Combine all exercises
const allExercises = [
    ...cardioPool.map(ex => ({ name: ex, type: 'cardio' })),
    ...strengthPool.map(ex => ({ name: ex, type: 'strength' })),
    ...yogaPool.map(ex => ({ name: ex, type: 'yoga' }))
];

// Initialize Exercise Gallery
function initExerciseGallery() {
    const gallery = document.getElementById('exerciseGallery');
    if (!gallery) {
        console.error('Exercise gallery element not found!');
        // Try to find it by different means
        const possibleGalleries = document.querySelectorAll('[id*="exercise"], [class*="exercise"], [id*="gallery"], [class*="gallery"]');
        console.log('Possible gallery elements:', possibleGalleries);
        return;
    }

    console.log('Initializing exercise gallery...');
    
    // Simple test - just add some basic exercises
    const testExercises = [
        'Jumping Jacks', 'Push-ups', 'Squats', 'Lunges', 'Burpees',
        'Mountain Climbers', 'High Knees', 'Plank', 'Sit-ups', 'Jump Rope'
    ];

    gallery.innerHTML = '<h4>Available Exercises</h4>';
    
    testExercises.forEach(exercise => {
        const div = document.createElement('div');
        div.style.cssText = 'padding: 10px; border: 1px solid #ccc; margin: 5px; border-radius: 5px;';
        div.innerHTML = `
            <input type="checkbox" value="${exercise}" id="ex-${exercise}">
            <label for="ex-${exercise}">${exercise}</label>
        `;
        gallery.appendChild(div);
    });

    console.log('Exercise gallery populated with', testExercises.length, 'exercises');
}
// Get exercise icon (using your existing icon mapping)
function getExerciseIcon(exerciseName) {
    const ICON_MAP = {
        /* Cardio */
        "Jumping Jacks": "fas fa-running",
        "High Knees": "fas fa-running",
        "Burpees": "fas fa-fire",
        "Mountain Climbers": "fas fa-mountain",
        "Sprints": "fas fa-tachometer-alt",
        "Butt Kickers": "fas fa-walking",
        "Skaters": "fas fa-bolt",
        "Jump Rope": "fas fa-person-jumping",
        "Tuck Jumps": "fas fa-arrow-up",
        "Lateral Hops": "fas fa-arrows-alt-h",
        "Jump Lunges": "fas fa-running",
        "Speed Skaters": "fas fa-bolt",
        "Box Jumps": "fas fa-box",
        "Stair Runs": "fas fa-step-forward",
        "Power Knees": "fas fa-bolt",

        /* Strength */
        "Squats": "fas fa-dumbbell",
        "Push-ups": "fas fa-hands",
        "Deadlifts": "fas fa-weight-hanging",
        "Bench Press": "fas fa-dumbbell",
        "Lunges": "fas fa-walking",
        "Overhead Press": "fas fa-arrow-up",
        "Bent-over Row": "fas fa-dumbbell",
        "Biceps Curls": "fas fa-hand-rock",
        "Tricep Dips": "fas fa-chair",
        "Romanian Deadlift": "fas fa-weight-hanging",
        "Chest Fly": "fas fa-heart",
        "Calf Raises": "fas fa-shoe-prints",
        "Hip Thrusts": "fas fa-arrow-up",
        "Farmer Carry": "fas fa-briefcase",
        "Pull-ups": "fas fa-arrows-alt-v",

        /* Yoga */
        "Sun Salutations": "fas fa-sun",
        "Warrior II": "fas fa-shield-alt",
        "Tree Pose": "fas fa-tree",
        "Downward Dog": "fas fa-paw",
        "Child's Pose": "fas fa-child",
        "Bridge Pose": "fas fa-archway",
        "Camel Pose": "fas fa-couch",
        "Seated Twist": "fas fa-sync-alt",
        "Standing Forward Bend": "fas fa-arrow-down",
        "Cat-Cow": "fas fa-cat",
        "Pigeon Pose": "fas fa-dove",
        "Boat Pose": "fas fa-ship",
        "Chair Pose": "fas fa-chair",
        "Eagle Pose": "fas fa-feather",
        "Reclining Bound Angle": "fas fa-bed"
    };

    return ICON_MAP[exerciseName] || 'fas fa-bolt';
}

// Toggle exercise selection
function toggleExerciseSelection(checkbox) {
    const card = checkbox.closest('.exercise-card');
    if (checkbox.checked) {
        card.style.borderColor = 'var(--primary-green)';
        card.style.background = 'rgba(46, 139, 87, 0.05)';
    } else {
        card.style.borderColor = 'var(--light-gray)';
        card.style.background = 'white';
    }
}

// Add selected exercises to workout
function addSelectedExercises() {
    const selectedCheckboxes = document.querySelectorAll('#exerciseGallery input:checked');
    const exerciseList = document.getElementById('exerciseList');
    
    if (selectedCheckboxes.length === 0) {
        alert('Please select at least one exercise from the library.');
        return;
    }

    selectedCheckboxes.forEach(checkbox => {
        const exerciseName = checkbox.value;
        
        const exerciseRow = document.createElement('div');
        exerciseRow.className = 'exercise-row';
        exerciseRow.style.cssText = 'display: flex; gap: 0.5rem; align-items: center; margin-bottom: 0.5rem;';
        
        exerciseRow.innerHTML = `
            <select name="exercise_name[]" class="form-control" style="flex: 2;">
                <option value="${exerciseName}" selected>${exerciseName}</option>
            </select>
            <input type="number" name="duration_seconds[]" class="form-control" placeholder="Seconds" value="45" min="10" max="600" style="flex: 1;">
            <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()" style="padding: 0.5rem;">
                <i class="fas fa-trash"></i>
            </button>
        `;
        
        exerciseList.appendChild(exerciseRow);
        
        // Uncheck the box
        checkbox.checked = false;
        toggleExerciseSelection(checkbox);
    });

    alert(`Added ${selectedCheckboxes.length} exercise(s) to your workout!`);
}

// Enhanced Exercise Management
function addExerciseRow() {
    const container = document.getElementById('exerciseList');
    const row = document.createElement('div');
    row.className = 'exercise-row';
    row.innerHTML = `
        <select name="exercise_name[]" class="form-control" onchange="updateExerciseImage(this)" required>
            <option value="">Select Exercise</option>
            ${allExercises.map(ex => 
                `<option value="${ex.name}">${ex.name}</option>`
            ).join('')}
        </select>
        <input type="number" name="duration_seconds[]" placeholder="Seconds" value="45" min="10" max="600" required>
        <button type="button" class="btn btn-danger" onclick="removeExerciseRow(this)">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(row);
}

function removeExerciseRow(button) {
    if (document.querySelectorAll('.exercise-row').length > 1) {
        button.parentElement.remove();
    } else {
        alert('Workout must have at least one exercise!');
    }
}

// Update exercise image preview (using your existing EXERCISE_IMAGES)
function updateExerciseImage(select) {
    // This function can be enhanced to show exercise images
    const exerciseName = select.value;
    if (exerciseName && EXERCISE_IMAGES[exerciseName]) {
        console.log('Exercise image available:', EXERCISE_IMAGES[exerciseName]);
    }
}

// Enhanced Save Custom Workout with exercise validation
async function saveCustomWorkout(formElement) {
    if (!requireAuth('save custom workouts')) return false;

    const messageEl = document.getElementById('responseMessage');
    const submitBtn = formElement.querySelector('button[type="submit"]');
    
    try {
        // Validate exercises
        const exerciseNames = formElement.querySelectorAll('select[name="exercise_name[]"]');
        const durations = formElement.querySelectorAll('input[name="duration_seconds[]"]');
        
        let hasErrors = false;
        exerciseNames.forEach((select, index) => {
            if (!select.value) {
                select.style.borderColor = 'red';
                hasErrors = true;
            } else {
                select.style.borderColor = '';
            }
        });

        if (hasErrors) {
            messageEl.textContent = 'Please select an exercise for all rows.';
            messageEl.style.color = 'red';
            return;
        }

        messageEl.textContent = 'Saving workout...';
        messageEl.style.color = '#333';
        
        submitBtn.disabled = true;
        
        const formData = new FormData(formElement);
        formData.append('email', localStorage.getItem('fitpm_user') || '');
        formData.append('action', 'save_custom_workout');
        
        const response = await fetch('save_custom_workout.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            messageEl.textContent = 'Workout saved successfully!';
            messageEl.style.color = 'green';
            formElement.reset();
            
            // Reset to one exercise row
            const exerciseList = document.getElementById('exerciseList');
            exerciseList.innerHTML = `
                <div class="exercise-row">
                    <select name="exercise_name[]" class="form-control" onchange="updateExerciseImage(this)" required>
                        <option value="">Select Exercise</option>
                        ${allExercises.map(ex => 
                            `<option value="${ex.name}">${ex.name}</option>`
                        ).join('')}
                    </select>
                    <input type="number" name="duration_seconds[]" placeholder="Seconds" value="45" min="10" max="600" required>
                    <button type="button" class="btn btn-danger" onclick="removeExerciseRow(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            
            // Reload my workouts
            loadMyWorkouts();
            
        } else {
            messageEl.textContent = 'Error: ' + (data.error || 'Failed to save workout');
            messageEl.style.color = 'red';
        }
        
    } catch (error) {
        console.error('Error saving workout:', error);
        messageEl.textContent = 'Network error. Please try again.';
        messageEl.style.color = 'red';
    } finally {
        submitBtn.disabled = false;
    }
}

// Start Custom Workout (integrated with your existing runner)
function startCustomWorkout(planId) {
    if (!requireAuth('start workouts')) return;
    
    // Fetch workout details and start the workout
    fetch(`get_custom_workout_details.php?id=${planId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Convert to the format expected by your workout runner
                const workoutSequence = data.workout.exercises.map(exercise => ({
                    name: exercise.exercise_name,
                    type: 'work',
                    duration: exercise.duration_seconds
                }));
                
                // Add warmup and cooldown
                const fullSequence = [
                    { name: 'Warm up (light cardio & mobility)', type: 'warmup' },
                    ...workoutSequence,
                    { name: 'Cool down (stretching)', type: 'cooldown' }
                ];
                
                // Start the workout using your existing runner
                startCustomWorkoutSequence(fullSequence, data.workout.workout_name);
                
            } else {
                alert('Error loading workout: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error starting workout:', error);
            alert('Error starting workout.');
        });
}

// New function to start custom workout sequence
function startCustomWorkoutSequence(sequence, workoutName) {
    // Use your existing workout runner infrastructure
    runnerExercises = sequence;
    runnerIndex = 0;
    runnerPaused = true;
    
    // Set workout title
    runnerTitle.textContent = workoutName;
    runnerSubtitle.textContent = 'Custom Workout - Follow the sequence';
    
    // Show workout detail page
    showPage('workout-detail');
    renderCurrent();
}

// Initialize custom workout page
function initCustomWorkoutPage() {
    const form = document.getElementById('customWorkoutForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            saveCustomWorkout(this);
        });
    }
    
    // Initialize exercise gallery
    initExerciseGallery();
    
    // Populate exercise dropdowns in existing rows
    document.querySelectorAll('select[name="exercise_name[]"]').forEach(select => {
        allExercises.forEach(exercise => {
            const option = document.createElement('option');
            option.value = exercise.name;
            option.textContent = exercise.name;
            select.appendChild(option);
        });
    });
    
    // Load initial data if on the right tab
    if (document.getElementById('custom-workout').classList.contains('active')) {
        loadMyWorkouts();
    }
}

// Update your existing DOMContentLoaded event listener
document.addEventListener('DOMContentLoaded', function() {
    // ... your existing code ...
    initCustomWorkoutPage();
});
function debugCustomWorkout() {
    console.log('=== CUSTOM WORKOUT DEBUG ===');
    console.log('1. Checking if custom workout page is active:', document.getElementById('custom-workout')?.classList.contains('active'));
    console.log('2. Exercise gallery element:', document.getElementById('exerciseGallery'));
    console.log('3. Tab buttons found:', document.querySelectorAll('.tab-btn').length);
    console.log('4. Tab contents found:', document.querySelectorAll('.tab-content').length);
    console.log('=== END DEBUG ===');
}

// Call this when custom workout page loads
function onCustomWorkoutPageLoad() {
    console.log('Custom workout page loaded!');
    initTabs();
    initExerciseGallery();
    debugCustomWorkout();
}
// Tab functionality
// Tab switching function
function showTab(tabName, event) {
    console.log('Switching to tab:', tabName);
    
    if (event) {
        event.preventDefault();
    }
    
    // Update tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    if (event) {
        event.target.classList.add('active');
    }
    
    // Show selected tab content
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    const targetTab = document.getElementById(`${tabName}-tab`);
    if (targetTab) {
        targetTab.classList.add('active');
        console.log('Activated tab content:', tabName + '-tab');
    } else {
        console.error('Tab content not found:', tabName + '-tab');
    }
    
    // Load data when switching to tabs
    if (tabName === 'my-workouts') {
        loadMyWorkouts();
    } else if (tabName === 'public-workouts') {
        loadPublicWorkouts();
    }
}

// Initialize tabs
function initTabs() {
    console.log('Initializing tabs...');
    const firstTab = document.querySelector('.tab-btn');
    if (firstTab) {
        firstTab.classList.add('active');
    }
    
    // Load initial data for active tab
    const activeTab = document.querySelector('.tab-content.active');
    if (activeTab && activeTab.id === 'my-workouts-tab') {
        loadMyWorkouts();
    } else if (activeTab && activeTab.id === 'public-workouts-tab') {
        loadPublicWorkouts();
    }
}
// Remove your old initExerciseGallery function completely
// We're using the modal system instead

function toggleExerciseSelection(checkbox) {
    const card = checkbox.closest('.exercise-card');
    if (checkbox.checked) {
        card.classList.add('selected');
    } else {
        card.classList.remove('selected');
    }
}

function addSelectedExercises() {
    const selected = document.querySelectorAll('#exerciseGallery input:checked');
    const exerciseList = document.getElementById('exerciseList');
    
    if (selected.length === 0) {
        alert('Please select exercises first!');
        return;
    }
    
    selected.forEach(checkbox => {
        const exerciseName = checkbox.value;
        const newRow = document.createElement('div');
        newRow.className = 'exercise-row';
        newRow.style.cssText = 'display: flex; gap: 0.5rem; margin-bottom: 0.5rem;';
        newRow.innerHTML = `
            <select name="exercise_name[]" class="form-control" style="flex: 2;">
                <option value="${exerciseName}" selected>${exerciseName}</option>
            </select>
            <input type="number" name="duration_seconds[]" class="form-control" placeholder="Seconds" value="45" min="10" max="600" style="flex: 1;">
            <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()" style="padding: 0.5rem;">
                <i class="fas fa-trash"></i>
            </button>
        `;
        exerciseList.appendChild(newRow);
        
        // Uncheck and reset
        checkbox.checked = false;
        toggleExerciseSelection(checkbox);
    });
    
    alert(`Added ${selected.length} exercise(s) to workout!`);
}

function addExerciseRow() {
    const exerciseList = document.getElementById('exerciseList');
    const newRow = document.createElement('div');
    newRow.className = 'exercise-row';
    newRow.style.cssText = 'display: flex; gap: 0.5rem; margin-bottom: 0.5rem;';
    newRow.innerHTML = `
        <input type="text" name="exercise_name[]" class="form-control" placeholder="Exercise Name" style="flex: 2;">
        <input type="number" name="duration_seconds[]" class="form-control" placeholder="Seconds" value="45" min="10" max="600" style="flex: 1;">
        <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()" style="padding: 0.5rem;">
            <i class="fas fa-trash"></i>
        </button>
    `;
    exerciseList.appendChild(newRow);
}

// Initialize when custom workout page is shown
document.addEventListener('DOMContentLoaded', function() {
    // Override showPage to detect when custom workout page is shown
    const originalShowPage = window.showPage;
    window.showPage = function(pageId) {
        if (typeof originalShowPage === 'function') {
            originalShowPage(pageId);
        } else {
            document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
            const page = document.getElementById(pageId);
            if (page) page.classList.add('active');
        }
        
        // Initialize custom workout page when shown
        if (pageId === 'custom-workout') {
            console.log('Custom workout page shown - initializing...');
            setTimeout(() => {
                initTabs();
                initExerciseGallery();
            }, 100);
        }
    };
});
async function loadMyWorkouts() {
    try {
        console.log("🔄 Loading custom workouts...");
        
        const response = await fetch('get_custom_workouts.php');
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const workouts = await response.json();
        console.log("✅ Workouts loaded:", workouts);
        
        const myWorkoutsContainer = document.getElementById('myWorkouts');
        
        if (!myWorkoutsContainer) {
            console.error("❌ Container #myWorkouts not found");
            return;
        }
        
        if (!workouts || workouts.length === 0) {
            myWorkoutsContainer.innerHTML = '<div style="text-align: center; padding: 2rem; color: #666;">No workouts yet. Create your first custom workout!</div>';
            return;
        }
        
        // Helper function for difficulty colors
        function getDifficultyColor(level) {
            const colors = {
                'Beginner': '#4caf50',
                'Intermediate': '#ff9800', 
                'Advanced': '#f44336'
            };
            return colors[level] || '#666';
        }
        
        myWorkoutsContainer.innerHTML = workouts.map(workout => `
            <div class="workout-card" data-workout-id="${workout.id}" style="
                background: var(--white);
                border-radius: 12px;
                padding: 1.5rem;
                margin-bottom: 1rem;
                border: 1px solid #eee;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            ">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                    <h4 style="margin: 0; color: var(--primary-green);">${workout.workout_name}</h4>
                    <span class="difficulty-badge" style="
                        background: ${getDifficultyColor(workout.difficulty_level)};
                        color: white;
                        padding: 0.25rem 0.75rem;
                        border-radius: 20px;
                        font-size: 0.8rem;
                        font-weight: 500;
                    ">${workout.difficulty_level}</span>
                </div>
                
                <p style="color: #666; margin-bottom: 1rem; line-height: 1.4;">
                    ${workout.description || 'No description provided'}
                </p>
                
                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem; color: #888;">
                    <div>
                        <span style="margin-right: 1rem;">
                            <i class="fas fa-dumbbell"></i> ${workout.exercise_count} exercises
                        </span>
                        <span style="margin-right: 1rem;">
                            <i class="fas fa-clock"></i> ${Math.round(workout.estimated_duration / 60)} min
                        </span>
                        <span>
                            <i class="fas fa-fire"></i> ${workout.estimated_calories_burn} cal
                        </span>
                    </div>
                    <div style="display: flex; gap: 0.5rem;">
                        <button onclick="startCustomWorkout(${workout.id})" class="btn" style="
                            background: var(--primary-green);
                            color: white;
                            border: none;
                            padding: 0.5rem 1rem;
                            border-radius: 6px;
                            cursor: pointer;
                            font-size: 0.9rem;
                        ">
                            <i class="fas fa-play"></i> Start
                        </button>
                        <button onclick="deleteWorkout(${workout.id})" class="btn" style="
                            background: #e53935;
                            color: white;
                            border: none;
                            padding: 0.5rem;
                            border-radius: 6px;
                            cursor: pointer;
                            font-size: 0.9rem;
                        ">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
        
        console.log(`✅ Displayed ${workouts.length} workouts`);
        
    } catch (error) {
        console.error('❌ Error loading workouts:', error);
        const myWorkoutsContainer = document.getElementById('myWorkouts');
        if (myWorkoutsContainer) {
            myWorkoutsContainer.innerHTML = `
                <div style="text-align: center; padding: 2rem; color: #e53935;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                    <p>Error loading workouts</p>
                    <p style="font-size: 0.9rem; color: #666;">${error.message}</p>
                </div>
            `;
        }
    }
}

function getDifficultyColor(difficulty) {
    const colors = {
        'Beginner': '#4caf50',
        'Intermediate': '#ff9800',
        'Advanced': '#f44336'
    };
    return colors[difficulty] || '#666';
}
async function loadPublicWorkouts() {
    try {
        const response = await fetch('get_public_workouts.php');
        const workouts = await response.json();
        
        const publicWorkoutsContainer = document.getElementById('publicWorkouts');
        
        if (workouts.length === 0) {
            publicWorkoutsContainer.innerHTML = '<div style="text-align: center; padding: 2rem; color: #666;">No public workouts available.</div>';
            return;
        }
        
        publicWorkoutsContainer.innerHTML = workouts.map(workout => `
            <div class="workout-card" style="
                background: var(--card-bg);
                border-radius: 12px;
                padding: 1.5rem;
                margin-bottom: 1rem;
                border: 1px solid var(--light-gray);
            ">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                    <h4 style="margin: 0; color: var(--primary-green);">${workout.workout_name}</h4>
                    <span class="difficulty-badge" style="
                        background: ${getDifficultyColor(workout.difficulty_level)};
                        color: white;
                        padding: 0.25rem 0.75rem;
                        border-radius: 20px;
                        font-size: 0.8rem;
                    ">${workout.difficulty_level}</span>
                </div>
                <p style="color: var(--dark-gray); margin-bottom: 1rem;">${workout.description || 'No description'}</p>
                <div style="color: var(--muted); font-size: 0.9rem; margin-bottom: 1rem;">
                    Created by: ${workout.creator_name}
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: var(--muted); font-size: 0.9rem;">
                        ${workout.exercise_count} exercises
                    </span>
                    <button onclick="startCustomWorkout(${workout.id})" class="btn btn-primary" style="padding: 0.5rem 1rem;">
                        <i class="fas fa-play"></i> Start
                    </button>
                </div>
            </div>
        `).join('');
        
    } catch (error) {
        console.error('Error loading public workouts:', error);
        document.getElementById('publicWorkouts').innerHTML = '<div style="text-align: center; padding: 2rem; color: #e53935;">Error loading public workouts</div>';
    }
}
function startCustomWorkout(workoutId) {
    console.log("Starting custom workout:", workoutId);
    // You'll implement this later
    alert("Starting workout " + workoutId);
}

// Delete workout function
async function deleteWorkout(workoutId) {
    if (!confirm('Are you sure you want to delete this workout?')) {
        return;
    }
    
    try {
        console.log("Deleting workout:", workoutId);
        const response = await fetch('delete_custom_workout.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({workout_id: workoutId})
        });
        
        const result = await response.json();
        
        if (result.success) {
            console.log("✅ Workout deleted successfully");
            loadMyWorkouts(); // Reload the list
        } else {
            alert('Error deleting workout: ' + result.error);
        }
    } catch (error) {
        console.error('Error deleting workout:', error);
        alert('Network error deleting workout');
    }
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Load workouts if we're on the custom workout page
    if (document.getElementById('custom-workout').classList.contains('active')) {
        loadMyWorkouts();
    }
});
async function saveCustomWorkout(formElement) {
  // Collect data from the form
  const workoutData = {
    workout_name: document.getElementById('workoutName').value,
    description: document.getElementById('workoutDescription').value || '',
    difficulty_level: document.getElementById('difficultyLevel').value || 'Beginner',
    is_public: document.getElementById('isPublic').checked ? 1 : 0,
    exercises: Array.from(document.querySelectorAll('#exerciseList .exercise-row')).map(row => ({
      name: row.querySelector('[name="exercise_name[]"], select[name="exercise_name[]"]').value,
      duration: parseInt(row.querySelector('[name="duration_seconds[]"]').value, 10)
    }))
  };

  const res = await fetch('save_custom_workout.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(workoutData)
  });

  const data = await res.json();
  // handle success/error...
}